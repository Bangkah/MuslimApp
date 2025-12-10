<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'surah_id','number','text_ar','text_id','tafsir'
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }
}
