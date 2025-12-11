<?php

use App\Http\Controllers\Frontend\QuranController;
use App\Http\Controllers\Frontend\PrayerTimeController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard aplikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Daftar surah Al-Qur'an
Route::get('/quran', [QuranController::class, 'index'])->name('frontend.quran.index');

// Detail surah dan ayat
Route::get('/quran/surah/{id}', [QuranController::class, 'show'])->name('frontend.quran.show');

// Halaman jadwal shalat
Route::get('/jadwal-shalat', [PrayerTimeController::class, 'index'])->name('frontend.prayertime.index');
Route::get('/jadwal-shalat/suggest-province', [PrayerTimeController::class, 'suggestProvince'])->name('frontend.prayertime.suggestProvince');
Route::get('/jadwal-shalat/suggest-city', [PrayerTimeController::class, 'suggestCity'])->name('frontend.prayertime.suggestCity');

// routes/web.php
Route::get('/jadwal-shalat/suggest-province', [PrayerTimeController::class, 'suggestProvince']);
Route::get('/jadwal-shalat/suggest-city', [PrayerTimeController::class, 'suggestCity']);
