<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
    use HasFactory;

    protected $table = 'quran'; // ← tambahkan ini

    protected $fillable = [
        'surah',
        'ayah',
        'arabic',
        'translation_id',
        'tafsir',
    ];
}