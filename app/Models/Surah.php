<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'name_latin',
        'number_of_ayah'
    ];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'surah_id');
    }
}