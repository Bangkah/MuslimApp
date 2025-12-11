<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard MuslimApp</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])    
</head>
<body class="bg-gray-100 min-h-screen">
    @extends('layouts.app')

    @section('content')
    <div class="flex flex-col min-h-screen">
        <!-- Jam Besar di Atas -->
        <div class="flex justify-center items-center py-12">
            <div class="bg-white rounded-2xl shadow-lg px-12 py-10 text-center w-full max-w-xl">
                <div class="text-gray-700 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                </div>
                <div class="font-bold text-5xl text-blue-700 mb-2" id="dashboard-clock">--:--:--</div>
                <div class="text-lg text-gray-500">Jam Saat Ini</div>
            </div>
        </div>
        <!-- Grid Fitur di Bawah -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-5xl mx-auto pb-16 animate-fade-in">
                <!-- Fitur Jadwal Shalat -->
                <a href="{{ route('frontend.prayertime.index') }}" class="block bg-white rounded-xl shadow p-6 text-center flex flex-col justify-center items-center transition-transform duration-300 hover:scale-105 cursor-pointer">
                    <div class="font-bold text-lg mb-2 text-blue-700">Jadwal Shalat</div>
                    <div id="prayertime-result" class="text-gray-700 text-sm">Deteksi lokasi untuk menampilkan jadwal shalat.</div>
                    <div id="prayertime-loading" class="hidden mt-2 text-blue-500 animate-pulse">Memuat jadwal shalat...</div>
                </a>
                <!-- Fitur Al-Qur'an -->
                <a href="{{ route('frontend.quran.index') }}" class="block bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center transition-transform duration-300 hover:scale-105">
                    <div class="text-blue-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" /></svg>
                    </div>
                    <div class="font-bold text-lg mb-1">Al-Qur'an</div>
                    <div class="text-gray-500 text-sm">Baca dan cari surah & ayat</div>
                </a>
                <!-- Fitur Al-Ma'surat -->
                <a href="#" class="block bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center opacity-60 cursor-not-allowed transition-transform duration-300 hover:scale-105">
                    <div class="text-yellow-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                    </div>
                    <div class="font-bold text-lg mb-1">Al-Ma'surat</div>
                    <div class="text-gray-500 text-sm">Segera hadir</div>
                </a>
                <!-- Fitur Arah Kiblat -->
                <a href="#" class="block bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center opacity-60 cursor-not-allowed transition-transform duration-300 hover:scale-105">
                    <div class="text-indigo-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" /></svg>
                    </div>
                    <div class="font-bold text-lg mb-1">Arah Kiblat</div>
                    <div class="text-gray-500 text-sm">Segera hadir</div>
                </a>
            </div>
        </div>
    </div>
    <script>
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('dashboard-clock').textContent = `${h}:${m}:${s}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Deteksi lokasi otomatis saat halaman dibuka
        window.addEventListener('DOMContentLoaded', function() {
            const resultEl = document.getElementById('prayertime-result');
            const loadingEl = document.getElementById('prayertime-loading');
            function showLoading(show) {
                if (show) {
                    loadingEl.classList.remove('hidden');
                } else {
                    loadingEl.classList.add('hidden');
                }
            }
            function showLocationError(msg) {
                resultEl.innerHTML = `<span class='text-red-500'>${msg}</span>`;
            }
            if (navigator.geolocation) {
                showLoading(true);
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    // Deteksi lokasi user (nama kota/provinsi)
                    fetch(`/api/detect-location?lat=${lat}&lon=${lon}`)
                        .then(res => res.json())
                        .then(loc => {
                            if(loc.success && loc.data) {
                                // Fetch jadwal shalat dari backend
                                fetch(`/api/prayertime?lat=${lat}&lon=${lon}&date=${new Date().toISOString().slice(0,10)}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        showLoading(false);
                                        if(data.success && data.data) {
                                            const p = data.data;
                                            resultEl.innerHTML =
                                                `<div class='font-semibold mb-2 animate-fade-in'>Jadwal Shalat Hari Ini</div>`+
                                                `<div class='mb-2 text-gray-600 text-sm'>${loc.data.city ? `${loc.data.city}, ${loc.data.province}` : ''}</div>`+
                                                `<div class='grid grid-cols-2 gap-2 text-sm'>`+
                                                `<div>Imsak</div><div>${p.imsak}</div>`+
                                                `<div>Subuh</div><div>${p.subuh}</div>`+
                                                `<div>Terbit</div><div>${p.terbit}</div>`+
                                                `<div>Dhuha</div><div>${p.dhuha}</div>`+
                                                `<div>Dzuhur</div><div>${p.dzuhur}</div>`+
                                                `<div>Ashar</div><div>${p.ashar}</div>`+
                                                `<div>Maghrib</div><div>${p.maghrib}</div>`+
                                                `<div>Isya</div><div>${p.isya}</div>`+
                                                `</div>`;
                                        } else {
                                            showLocationError('Jadwal shalat tidak ditemukan untuk lokasi Anda.');
                                        }
                                    })
                                    .catch(() => {
                                        showLoading(false);
                                        showLocationError('Gagal memuat jadwal shalat.');
                                    });
                            } else {
                                showLoading(false);
                                showLocationError('Gagal mendeteksi lokasi: ' + (loc.message || 'Tidak ditemukan kota terdekat.'));
                            }
                        })
                        .catch(() => {
                            showLoading(false);
                            showLocationError('Gagal mendeteksi lokasi.');
                        });
                }, function(error) {
                    showLoading(false);
                    showLocationError('Gagal mendeteksi lokasi: ' + error.message);
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                });
            } else {
                showLocationError('Browser tidak mendukung geolocation.');
            }
        });
    </script>
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.7s ease;
        }
    </style>
    @endsection
</body>
</html>