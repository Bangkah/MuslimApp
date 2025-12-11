<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class PrayerTimeController extends Controller
{
    /**
     * Halaman utama jadwal shalat
     */
    public function index(Request $request)
    {
        $lat  = $request->query('lat');
        $lon  = $request->query('lon');
        $date = $request->query('date', date('Y-m-d'));

        $prayertime = null;

        // Jika ada koordinat, ambil jadwal dari API backend
        if ($lat && $lon) {
            $response = Http::get(url('/api/prayertime'), [
                'lat'  => $lat,
                'lon'  => $lon,
                'date' => $date,
            ]);

            if ($response->ok()) {
                $prayertime = $response->json('data');
            }
        }

        return view('prayertime.index', compact('prayertime', 'lat', 'lon', 'date'));
    }

    /**
     * Suggest Provinsi untuk input manual
     */
    public function suggestProvince(Request $request)
    {
        $q = $request->input('q');

        $provinces = City::where('province_name', 'like', "%{$q}%")
            ->orderBy('province_name')
            ->groupBy('province_name')
            ->limit(10)
            ->pluck('province_name');

        return response()->json($provinces);
    }

    /**
     * Suggest Kota berdasarkan provinsi
     */
    public function suggestCity(Request $request)
    {
        $province = $request->input('province');
        $q        = $request->input('q');

        $query = City::query();

        if ($province) {
            $query->where('province_name', $province);
        }

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        $cities = $query->orderBy('name')
            ->limit(10)
            ->pluck('name');

        return response()->json($cities);
    }
}
