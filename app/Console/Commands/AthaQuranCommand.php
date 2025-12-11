<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Surah;
use App\Models\Ayah;
use Illuminate\Support\Facades\DB;

class AthaQuranCommand extends Command
{
    protected $signature = 'atha:quran {action}';
    protected $description = 'Manajemen data Quran (info, import, clear)';

    public function handle()
    {
        $action = $this->argument('action');

        return match ($action) {
            'info'   => $this->infoQuran(),
            'import' => $this->importQuran(),
            'clear'  => $this->clearQuran(),
            default  => $this->error("Perintah tidak dikenal. Gunakan: info | import | clear")
        };
    }

    // ------------------------------------------------------
    // INFO
    // ------------------------------------------------------
    private function infoQuran()
    {
        $totalSurah = Surah::count();
        $totalAyat  = Ayah::count();

        $this->info("📘 Total Surah : {$totalSurah}");
        $this->info("📗 Total Ayat  : {$totalAyat}");

        return 0;
    }

    // ------------------------------------------------------
    // CLEAR
    // ------------------------------------------------------
    private function clearQuran()
    {
        Surah::truncate();
        Ayah::truncate();

        $this->warn("⚠️ Semua data Quran sudah dihapus.");
        return 0;
    }

    // ------------------------------------------------------
    // IMPORT
    // ------------------------------------------------------
    private function importQuran()
    {
        $this->info("⏳ Mengimpor data Quran...");

        $files = Storage::files('quran');

        if (count($files) === 0) {
            return $this->error("❌ Tidak ada file JSON ditemukan di storage/app/quran");
        }

        DB::transaction(function () use ($files) {
            Surah::truncate();
            Ayah::truncate();

            $bar = $this->output->createProgressBar(count($files));
            $bar->start();

            foreach ($files as $file) {
                $json = json_decode(Storage::get($file), true);

                if (!$json) {
                    $this->error("❌ JSON rusak: $file");
                    $bar->advance();
                    continue;
                }

                $surah = Surah::create([
                    'number'      => $json['number'] ?? 0,
                    'name_ar'     => $json['name_ar'] ?? '',
                    'name_en'     => $json['name_en'] ?? '',
                    'name_id'     => $json['name_id'] ?? '',
                    'revelation'  => $json['revelation'] ?? '',
                    'ayah_count'  => isset($json['ayahs']) ? count($json['ayahs']) : 0,
                ]);

                if (isset($json['ayahs']) && is_array($json['ayahs'])) {
                    foreach ($json['ayahs'] as $a) {
                        Ayah::create([
                            'surah_id' => $surah->id,
                            'number'   => $a['number'] ?? 0,
                            'text_ar'  => $a['text_ar'] ?? '',
                            'text_id'  => $a['text_id'] ?? null,
                            'tafsir'   => $a['tafsir'] ?? null,
                        ]);
                    }
                }

                $bar->advance();
            }

            $bar->finish();
        });

        $this->info("\n🎉 Import Quran selesai.");
        return 0;
    }
}
