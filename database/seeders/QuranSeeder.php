<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surah;
use App\Models\Ayah;

class QuranSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 114; $i++) {

            // Path file JSON
            $path = storage_path("app/quran/$i.json");

            if (!file_exists($path)) {
                echo "File quran/$i.json tidak ditemukan\n";
                continue;
            }

            // Decode JSON
            $json = json_decode(file_get_contents($path), true);

            // Struktur JSON: { "1": { ... } }
            if (!isset($json[$i])) {
                echo "Format JSON tidak valid untuk surah $i\n";
                continue;
            }

            $surahData = $json[$i];

            // Insert ke tabel surahs
            $surah = Surah::create([
                'number'           => $surahData['number'],
                'name'             => $surahData['name'],
                'name_latin'       => $surahData['name_latin'],
                'number_of_ayah'   => $surahData['number_of_ayah'],
            ]);

            // Insert ayat satu per satu
            foreach ($surahData['text'] as $key => $arabic) {
                Ayah::create([
                    'surah_id'       => $surah->id,
                    'ayah_number'    => $key,
                    'text_arab'      => $arabic,
                    'translation_id' => $surahData['translations']['id']['text'][$key] ?? null,
                    'tafsir_id'      => $surahData['tafsir']['id']['kemenag']['text'][$key] ?? null,
                ]);
            }

            echo "Surah $i selesai dimasukkan.\n";
        }
    }
}
