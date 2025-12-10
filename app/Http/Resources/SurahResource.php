<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurahResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'name_latin' => $this->name_latin,
            'number_of_ayah' => $this->ayahs_count ?? $this->number_of_ayah,
            // Hanya tampilkan ayahs jika relasi sudah di-load (detail surah)
            'ayahs' => $this->when(
                $this->relationLoaded('ayahs'),
                fn() => AyahResource::collection($this->ayahs)
            ),
        ];
    }
}
