<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AyahResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'surah' => $this->whenLoaded('surah', function () {
                return [
                    'id' => $this->surah->id,
                    'number' => $this->surah->number,
                    'name' => $this->surah->name,
                    'name_latin' => $this->surah->name_latin,
                    'number_of_ayah' => $this->surah->number_of_ayah,
                ];
            }),
            'ayah_number' => $this->ayah_number,
            'text_arab' => $this->text_arab,
            'translation_id' => $this->translation_id,
            'tafsir_id' => $this->tafsir_id,
        ];
    }
}
