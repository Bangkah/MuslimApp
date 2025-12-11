<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    /**
     * Tampilkan daftar surah di halaman frontend.
     */
    public function index()
    {
        $response = Http::get(route('api.surahs'));

        if ($response->failed()) {
            abort(500, 'Gagal mengambil data surah.');
        }

        $surahs = $response->json('data');

        return view('quran.index', compact('surahs'));
    }

    /**
     * Tampilkan detail surah beserta ayat-ayatnya di halaman frontend.
     */
    public function show($id)
    {
        $response = Http::get(route('api.surah', ['surah' => $id]));

        if ($response->failed()) {
            abort(500, 'Gagal mengambil detail surah.');
        }

        $surah = $response->json('data');

        return view('quran.show', compact('surah'));
    }

    /**
     * Tampilkan hasil pencarian ayat atau Quran di halaman frontend.
     */
    public function search()
    {
        $query = request('q');

        $response = Http::get(route('api.search', ['q' => $query]));

        if ($response->failed()) {
            abort(500, 'Gagal melakukan pencarian.');
        }

        $results = $response->json('data');

        return view('quran.search', compact('results'));
    }
}