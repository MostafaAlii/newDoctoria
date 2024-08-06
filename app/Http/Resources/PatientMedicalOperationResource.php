<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientMedicalOperationResource extends JsonResource
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
            'date_of_operation'=>$this->date_of_operation,
            'note'=>$this->note,
            'medicalOperation'=>new MedicalOperationResource($this->whenLoaded('medicalOperation')),
        ];
    }
}
