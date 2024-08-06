<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'slug'=>$this->slug,
            'name'=>$this->getTranslation('name', session_lang()),
            'icon'=>get_file($this->icon),
            'mainService'=>new MainServiceResource($this->whenLoaded('mainService')),

        ];
    }
}
