<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorBranchResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'image'=>get_file($this->image),
            'location'=>$this->location,
            'about'=>$this->getTranslation('about', session_lang()),
            'price'=>$this->price,
            'times' => ProviderTimeResource::collection($this->whenLoaded('times')),
        ];
    }
}
