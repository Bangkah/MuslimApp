<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'surah_id',
        'ayah_number',
        'text_arab',
        'translation_id',
        'tafsir_id',
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class);
    }
}
