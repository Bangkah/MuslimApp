<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $fillable = [
        'number','name_ar','name_en','name_id','revelation','ayah_count'
    ];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class);
    }
}