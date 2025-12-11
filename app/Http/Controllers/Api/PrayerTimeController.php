<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrayerTime;
use App\Models\City;

class PrayerTimeController extends Controller
{
    public function index(Request $request)
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');
        $date = $request->query('date', date('Y-m-d'));
        $cityName = $request->query('city');
        $province = $request->query('province');

        $city = null;

        /**
         * ---------------------------------------------------------
         * 1. MODE OTOMATIS (KOORDINAT)
         * ---------------------------------------------------------
         */
        if ($lat && $lon) {
            $detector = new LocationDetectController();
            $detect = $detector->detect($request)->getData();

            if ($detect->success) {
                $cityName = $detect->data->city;
                $province = $detect->data->province;

                $city = City::where('name', $cityName)
                            ->where('province_name', $province)
                            ->first();

                if ($city) {
                    $lat = $city->latitude;
                    $lon = $city->longitude;
                }
            }
        }

        /**
         * ---------------------------------------------------------
         * 2. MODE MANUAL (CITY NAME)
         * ---------------------------------------------------------
         */
        if ($cityName && !$city) {
            $query = City::where('name', 'LIKE', "%{$cityName}%");

            if ($province) {
                $query->where('province_name', $province);
            }

            $city = $query->first();

            if (!$city) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kota/kabupaten tidak ditemukan.',
                    'data' => null
                ], 404);
            }

            $lat = $city->latitude;
            $lon = $city->longitude;
            $cityName = $city->name;
            $province = $city->province_name;
        }

        /**
         * ---------------------------------------------------------
         * 3. GAGAL MENDAPATKAN LOKASI
         * ---------------------------------------------------------
         */
        if (!$lat || !$lon) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak valid. Izinkan GPS atau masukkan nama kota.',
                'data' => null
            ], 422);
        }

        /**
         * ---------------------------------------------------------
         * 4. CARI ATAU BUAT JADWAL SHALAT
         * ---------------------------------------------------------
         */
        $prayer = PrayerTime::where('city', $cityName ?? "$lat,$lon")
            ->where('date', $date)
            ->first();

        if (!$prayer) {
            $jadwal = $this->generatePrayerTimes($lat, $lon, $date);

            $prayer = PrayerTime::create([
                'city' => $cityName ?? "$lat,$lon",
                'date' => $date,
                'imsak' => $jadwal['imsak'],
                'subuh' => $jadwal['subuh'],
                'terbit' => $jadwal['terbit'],
                'dhuha' => $jadwal['dhuha'],
                'dzuhur' => $jadwal['dzuhur'],
                'ashar' => $jadwal['ashar'],
                'maghrib' => $jadwal['maghrib'],
                'isya' => $jadwal['isya'],
            ]);
        }

        /**
         * ---------------------------------------------------------
         * 5. RETURN RESPONSE
         * ---------------------------------------------------------
         */
        return response()->json([
            'success' => true,
            'message' => 'Jadwal shalat berhasil diambil.',
            'data' => [
                'city' => $cityName,
                'province' => $province,
                'latitude' => $lat,
                'longitude' => $lon,
                'date' => $date,
                'imsak' => $prayer->imsak,
                'subuh' => $prayer->subuh,
                'terbit' => $prayer->terbit,
                'dhuha' => $prayer->dhuha,
                'dzuhur' => $prayer->dzuhur,
                'ashar' => $prayer->ashar,
                'maghrib' => $prayer->maghrib,
                'isya' => $prayer->isya,
            ]
        ]);
    }


    /**
     * ---------------------------------------------------------
     * PRAYER TIME GENERATOR (RUMUS FISIKA)
     * ---------------------------------------------------------
     */
    private function generatePrayerTimes($lat, $lon, $date)
    {
        $timestamp = strtotime($date);
        $dayOfYear = date('z', $timestamp) + 1;

        // Estimasi sederhana (model sinus tahunan)
        $declination = 23.45 * sin(deg2rad((360/365) * ($dayOfYear - 81)));

        // Waktu Dzuhur (solar noon)
        $noon = 12 - ($lon / 15);

        // Sudut Fajr/Isya
        $fajrAngle = -20;
        $isyaAngle = -18;

        return [
            'imsak'   => date("H:i", strtotime(($noon - 1.5) . ":00")),
            'subuh'   => date("H:i", strtotime(($noon - 1.3) . ":00")),
            'terbit'  => date("H:i", strtotime(($noon - 1) . ":00")),
            'dhuha'   => date("H:i", strtotime(($noon - 0.5) . ":00")),
            'dzuhur'  => date("H:i", strtotime($noon . ":00")),
            'ashar'   => date("H:i", strtotime(($noon + 3) . ":00")),
            'maghrib' => date("H:i", strtotime(($noon + 1) . ":00")),
            'isya'    => date("H:i", strtotime(($noon + 2) . ":00")),
        ];
    }

    // app/Http/Controllers/Frontend/PrayerTimeController.php

public function suggestProvince(Request $request)
{
    $keyword = $request->query('q', '');

    if (strlen($keyword) < 2) {
        return response()->json([]);
    }

    $provinces = City::where('province_name', 'like', "%{$keyword}%")
        ->groupBy('province_name')
        ->orderBy('province_name')
        ->limit(10)
        ->pluck('province_name');

    return response()->json($provinces);
}

public function suggestCity(Request $request)
{
    $province = $request->query('province', '');
    $keyword  = $request->query('q', '');

    if (!$province || strlen($keyword) < 2) {
        return response()->json([]);
    }

    $cities = City::where('province_name', $province)
        ->where('name', 'like', "%{$keyword}%")
        ->orderBy('name')
        ->limit(10)
        ->pluck('name');

    return response()->json($cities);
}

}
    /**
     * ---------------------------------------------------------
     * PRAYER TIME GENERATOR (RUMUS FISIKA)
     * ---------------------------------------------------------
     */
//     private function generatePrayerTimes($lat, $lon, $date)
//     {
//         $timestamp = strtotime($date);
//         $dayOfYear = date('z', $timestamp) + 1;

//         // Estimasi sederhana (model sinus tahunan)
//         $declination = 23.45 * sin(deg2rad((360/365) * ($dayOfYear - 81)));

//         // Waktu Dzuhur (solar noon)
//         $noon = 12 - ($lon / 15);

//         // Sudut Fajr/Isya
//         $fajrAngle = -20;
//         $isyaAngle = -18;

//         return [
//             'imsak'   => date("H:i", strtotime(($noon - 1.5) . ":00")),
//             'subuh'   => date("H:i", strtotime(($noon - 1.3) . ":00")),
//             'terbit'  => date("H:i", strtotime(($noon - 1) . ":00")),
//             'dhuha'   => date("H:i", strtotime(($noon - 0.5) . ":00")),
//             'dzuhur'  => date("H:i", strtotime($noon . ":00")),
//             'ashar'   => date("H:i", strtotime(($noon + 3) . ":00")),
//             'maghrib' => date("H:i", strtotime(($noon + 1) . ":00")),
//             'isya'    => date("H:i", strtotime(($noon + 2) . ":00")),
//         ];
//     }
// }

