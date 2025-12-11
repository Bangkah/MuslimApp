<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'id', 'province_id', 'province_name', 'name', 'latitude', 'longitude'
    ];
    public $timestamps = false;
}
