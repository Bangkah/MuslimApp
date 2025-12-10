<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AyahController extends Controller
{
    // GET /api/ayah/{id}
    public function show($id)
    {
        $ayah = DB::table('ayahs')->where('id', $id)->first();
        if (!$ayah) {
            return response()->json([
                'status' => false,
                'message' => 'Ayat tidak ditemukan.'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail ayat berhasil diambil.',
            'data' => $ayah
        ], 200);
    }
}