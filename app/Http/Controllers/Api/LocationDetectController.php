<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class LocationDetectController extends Controller
{
    public function detect(Request $request)
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        if (!$lat || !$lon) {
            return response()->json([
                'success' => false,
                'message' => 'Latitude dan longitude wajib diisi.',
                'data' => null
            ], 422);
        }

        $sql = "
            *, (
                6371 * acos(
                    cos(radians(?)) * cos(radians(latitude))
                    * cos(radians(longitude) - radians(?))
                    + sin(radians(?)) * sin(radians(latitude))
                )
            ) AS distance
        ";

        $bindings = [$lat, $lon, $lat];

        $city = City::selectRaw($sql, $bindings)
            ->orderBy('distance')
            ->first();

        if (!$city) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ditemukan kota terdekat.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lokasi terdekat ditemukan.',
            'data' => [
                'city' => $city->name,
                'province' => $city->province_name,
                'latitude' => $city->latitude,
                'longitude' => $city->longitude,
                'distance_km' => round($city->distance, 2)
            ]
        ]);
    }
}
