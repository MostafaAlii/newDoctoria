<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationResource extends JsonResource
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
            'color'=>$this->color,
            'icon'=>get_file($this->icon),
            'image'=>get_file($this->image),
            'limitPopularDoctors' => DoctorResource::collection($this->whenLoaded('limitPopularDoctors')),

        ];
    }
}
