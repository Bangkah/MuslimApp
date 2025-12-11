<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Quran;
use Illuminate\Http\Request;

class QuranController extends Controller
{
    /**
     * Tampilkan daftar surah di halaman frontend.
     */
    public function index()
    {
        $surahs = Surah::withCount('ayahs')->orderBy('id')->get();
        return view('quran.index', compact('surahs'));
    }

    /**
     * Tampilkan detail surah beserta ayat-ayatnya di halaman frontend.
     */
    public function show($id)
    {
        $surah = Surah::with(['ayahs' => function($query) {
            $query->orderBy('id');
        }])->findOrFail($id);
        return view('quran.show', compact('surah'));
    }

    /**
     * Tampilkan hasil pencarian ayat atau Quran di halaman frontend.
     */
    public function search(Request $request)
    {
        $q = $request->query('q');
        $ayahResults = Ayah::with('surah')
            ->where('text_arab', 'like', "%{$q}%")
            ->orWhere('translation_id', 'like', "%{$q}%")
            ->orderBy('id')
            ->get();
        $quranResults = Quran::where('arabic', 'like', "%{$q}%")
            ->orWhere('translation_id', 'like', "%{$q}%")
            ->orWhere('tafsir', 'like', "%{$q}%")
            ->orderBy('id')
            ->get();
        $results = [
            'ayah' => $ayahResults,
            'quran' => $quranResults
        ];
        return view('quran.search', compact('results'));
    }
}
