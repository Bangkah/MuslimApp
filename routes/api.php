<?php

use App\Http\Controllers\Api\QuranController;
use Illuminate\Support\Facades\Route;

Route::get('/surahs', [QuranController::class, 'surahs']);
Route::get('/surah/{id}', [QuranController::class, 'surah']);
Route::get('/ayah/{id}', [QuranController::class, 'ayah']);
