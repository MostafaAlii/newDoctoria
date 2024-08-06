<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalBagResource extends JsonResource
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
            'unit'=>$this->unit,
            'value' => doubleval($this->value), // Convert 'value' to double
            'category'=>new CategoryResource($this->whenLoaded('category')),
            'patient'=>new PatientResource($this->whenLoaded('patient')),

        ];
    }
}
