<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;

class QuranController extends Controller
{
    public function surahs()
    {
        return Surah::select('id','number','name_ar','name_id','revelation','ayah_count')->get();
    }

    public function surah($id)
    {
        return [
            'surah' => Surah::findOrFail($id),
            'ayahs' => Ayah::where('surah_id', $id)->get()
        ];
    }

    public function ayah($id)
    {
        return Ayah::findOrFail($id);
    }
}
