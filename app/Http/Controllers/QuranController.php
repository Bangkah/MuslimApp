<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QuranController extends Controller
{
    public function surahs()
    {
        $surahs = DB::table('surahs')->get(['id', 'name', 'number', 'name_latin', 'number_of_ayah']);
        return response()->json([
            'status' => 'success',
            'count' => $surahs->count(),
            'data' => $surahs
        ]);
    }

    public function surah($id)
    {
        $surah = DB::table('surahs')->where('id', $id)->first();
        if (!$surah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Surah not found.'
            ], 404);
        }
        $ayahs = DB::table('ayahs')
            ->where('surah_id', $id)
            ->orderBy('number')
            ->get(['id', 'number', 'text_ar', 'text_id']);
        return response()->json([
            'status' => 'success',
            'surah' => $surah,
            'ayahs' => $ayahs
        ]);
    }
}
