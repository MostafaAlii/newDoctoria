<?php

namespace App\Http\Resources;

use App\Models\RadiologyCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RadiologyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>(int)$this->id,
            'name'=>$this->getTranslation('name', session_lang()),
            'price'=>$this->price,
            'radiologyCenter'=>new RadiologyCenterResource($this->whenLoaded('radiologyCenter')),

        ];
    }
}
