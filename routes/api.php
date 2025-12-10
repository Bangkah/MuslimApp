<?php

use App\Http\Controllers\Api\QuranController;
use Illuminate\Support\Facades\Route;


// Daftar semua surah
Route::get('/surahs', [QuranController::class, 'surahs']);

// Detail satu surah beserta semua ayat
Route::get('/surah/{surah}', [QuranController::class, 'surah']);

// Daftar semua ayat
Route::get('/ayahs', [QuranController::class, 'ayahs']);

// Detail satu ayat
Route::get('/ayah/{ayah}', [QuranController::class, 'ayah']);

// Semua data Quran
Route::get('/quran', [QuranController::class, 'quran']);

// Pencarian ayat atau Quran berdasarkan kata kunci
Route::get('/search', [QuranController::class, 'search']);
