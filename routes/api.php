<?php

use App\Http\Controllers\Api\QuranController;
use Illuminate\Support\Facades\Route;

Route::get('surahs', [QuranController::class, 'surahs']);
Route::get('surah/{surah}', [QuranController::class, 'surah']);
Route::get('ayahs', [QuranController::class, 'ayahs']);
Route::get('ayah/{ayah}', [QuranController::class, 'ayah']);
Route::get('quran', [QuranController::class, 'quran']);
Route::get('search', [QuranController::class, 'search']);
