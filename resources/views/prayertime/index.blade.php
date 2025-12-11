@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-xl shadow p-8 mt-8">
    <h1 class="text-2xl font-bold text-blue-700 mb-4 text-center">Jadwal Shalat Hari Ini</h1>
    <div id="location-form-container">
        <form id="manual-location-form" class="mb-6 hidden">
            <div class="mb-2 relative">
                <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                <input type="text" id="province" name="province" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required autocomplete="off">
                <ul id="province-suggestions" class="absolute z-10 bg-white border border-gray-300 rounded w-full mt-1 hidden max-h-40 overflow-y-auto"></ul>
            </div>
            <div class="mb-2 relative">
                <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                <input type="text" id="city" name="city" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required autocomplete="off" disabled>
                <ul id="city-suggestions" class="absolute z-10 bg-white border border-gray-300 rounded w-full mt-1 hidden max-h-40 overflow-y-auto"></ul>
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Lihat Jadwal Shalat</button>
        </form>
        <div id="manual-location-info" class="text-center text-gray-500 mb-4 hidden">Masukkan daerah dan kota untuk melihat jadwal shalat.</div>
    </div>
    @if($prayertime)
        <div class="mb-4 text-center text-gray-600">
            Lokasi: <span class="font-semibold">{{ $prayertime['city'] ?? ($lat && $lon ? "$lat, $lon" : '-') }}</span><br>
            Tanggal: <span class="font-semibold">{{ $date }}</span>
        </div>
        <div class="grid grid-cols-2 gap-   4">
            <div class="font-semibold">Imsak</div><div>{{ $prayertime['imsak'] }}</div>
            <div class="font-semibold">Subuh</div><div>{{ $prayertime['subuh'] }}</div>
            <div class="font-semibold">Terbit</div><div>{{ $prayertime['terbit'] }}</div>
            <div class="font-semibold">Dhuha</div><div>{{ $prayertime['dhuha'] }}</div>
            <div class="font-semibold">Dzuhur</div><div>{{ $prayertime['dzuhur'] }}</div>
            <div class="font-semibold">Ashar</div><div>{{ $prayertime['ashar'] }}</div>
            <div class="font-semibold">Maghrib</div><div>{{ $prayertime['maghrib'] }}</div>
            <div class="font-semibold">Isya</div><div>{{ $prayertime['isya'] }}</div>
        </div>
    @else
        <div class="text-center text-gray-500">Silakan deteksi lokasi di dashboard atau input manual untuk melihat jadwal shalat.</div>
    @endif
    <div class="mt-8 text-center">
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">&#8592; Kembali ke Dashboard</a>
    </div>
</div>
<script>
   // =============================
//   AUTOCOMPLETE PROVINSI
// =============================
provinceInput.addEventListener('input', function () {
    const val = provinceInput.value.trim();

    if (val.length < 2) {
        provinceBox.classList.add('hidden');
        return;
    }

    clearTimeout(debounceProvince);
    debounceProvince = setTimeout(() => {
        fetch(`/jadwal-shalat/suggest-province?q=${encodeURIComponent(val)}`)
            .then(res => res.json())
            .then(list => {
                if (!list.length) {
                    provinceBox.innerHTML = "<li class='px-3 py-2 text-gray-400'>Tidak ada saran</li>";
                    provinceBox.classList.remove('hidden');
                    return;
                }

                provinceBox.innerHTML = list
                    .map(p => `<li class='px-3 py-2 hover:bg-blue-100 cursor-pointer' data-p='${p}'>${p}</li>`)
                    .join('');

                provinceBox.classList.remove('hidden');
            });
    }, 300);
});

provinceBox.addEventListener('mousedown', function (e) {
    if (e.target.dataset.p) {
        provinceInput.value = e.target.dataset.p;
        provinceBox.classList.add('hidden');

        cityInput.value = "";
        cityInput.disabled = false;
        cityBox.classList.add('hidden');
    }
});

// =============================
//   AUTOCOMPLETE KOTA
// =============================
cityInput.addEventListener('input', function () {
    const val = cityInput.value.trim();
    const prov = provinceInput.value.trim();

    if (val.length < 2 || !prov) {
        cityBox.classList.add('hidden');
        return;
    }

    clearTimeout(debounceCity);
    debounceCity = setTimeout(() => {
        fetch(`/jadwal-shalat/suggest-city?q=${encodeURIComponent(val)}&province=${encodeURIComponent(prov)}`)
            .then(res => res.json())
            .then(list => {
                if (!list.length) {
                    cityBox.innerHTML = "<li class='px-3 py-2 text-gray-400'>Tidak ada saran</li>";
                    cityBox.classList.remove('hidden');
                    return;
                }

                cityBox.innerHTML = list
                    .map(c => `<li class='px-3 py-2 hover:bg-blue-100 cursor-pointer' data-c='${c}'>${c}</li>`)
                    .join('');

                cityBox.classList.remove('hidden');
            });
    }, 300);
});

cityBox.addEventListener('mousedown', function (e) {
    if (e.target.dataset.c) {
        cityInput.value = e.target.dataset.c;
        cityBox.classList.add('hidden');
    }
});
</script>
@endsection