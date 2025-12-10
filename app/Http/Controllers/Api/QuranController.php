<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Quran;

class QuranController extends Controller
{
    /**
     * GET /api/surahs
     * Ambil semua surah beserta jumlah ayat, urut berdasarkan id
     */
    public function surahs()
    {
        $surahs = Surah::with('ayahs')
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar surah berhasil diambil.',
            'data' => $surahs
        ]);
    }

    /**
     * GET /api/surah/{surah}
     * Ambil detail surah beserta semua ayat, ayat urut berdasarkan id
     */
    public function surah(Surah $surah)
    {
        $surah = Surah::all()
            ->orderBy('id')
            ->get();

        // $surah->load(['ayahs' => function($query) {
        //     $query->orderBy('id');
        // }]);

        return response()->json([
            'success' => true,
            'message' => 'Detail surah berhasil diambil.',
            'data' => $surah
        ]);
    }

    /**
     * GET /api/ayahs
     * Ambil semua ayat beserta informasi surah, urut berdasarkan id
     */
    public function ayahs()
    {
        $ayahs = Ayah::with('surah')
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar ayat berhasil diambil.',
            'data' => $ayahs
        ]);
    }

    /**
     * GET /api/ayah/{ayah}
     * Ambil detail ayat beserta informasi surah
     */
    public function ayah(Ayah $ayah)
    {
        $ayah->load('surah');

        return response()->json([
            'success' => true,
            'message' => 'Detail ayat berhasil diambil.',
            'data' => $ayah
        ]);
    }

    /**
     * GET /api/quran
     * Ambil semua data dari tabel quran, urut berdasarkan id
     */
    public function quran()
{
    $data = Quran::orderBy('id')->get(); // ambil semua data
    return response()->json([
        'success' => true,
        'message' => 'Data Quran berhasil diambil.',
        'data' => $data
    ]);
}


    /**
     * GET /api/search?q=kata
     * Cari ayat di Ayah atau Quran berdasarkan kata kunci
     */
    public function search(Request $request)
{
    $q = $request->query('q');

    if (!$q) {
        return response()->json([
            'success' => false,
            'message' => 'Parameter q wajib diisi.'
        ], 400);
    }

    // Cari di tabel Ayah
    $ayahResults = Ayah::with('surah')
        ->where(function($query) use ($q) {
            $query->where('text_arab', 'like', "%{$q}%")
                  ->orWhere('translation_id', 'like', "%{$q}%");
        })
        ->orderBy('id')
        ->get();

    // Cari di tabel Quran
    $quranResults = Quran::where(function($query) use ($q) {
            $query->where('arabic', 'like', "%{$q}%")
                  ->orWhere('translation_id', 'like', "%{$q}%")
                  ->orWhere('tafsir', 'like', "%{$q}%");
        })
        ->orderBy('id')
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'Hasil pencarian ayat.',
        'data' => [
            'ayah' => $ayahResults,
            'quran' => $quranResults
        ]
    ]);
}

}
