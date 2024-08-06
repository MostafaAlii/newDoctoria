<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplayingBookingMedicalResource extends JsonResource
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
            'note'=>$this->note,
            'provider'=>PharmacyResource::make($this->pharmacy),
            'provider_data'=>MedicationUnitResource::make($this->medicationUnit),
            'medicationWay'=>MedicationWayResource::make($this->medicationWay),


        ];
    }
}
