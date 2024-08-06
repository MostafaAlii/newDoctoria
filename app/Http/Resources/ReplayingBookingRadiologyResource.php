<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplayingBookingRadiologyResource extends JsonResource
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
            'provider'=>RadiologyCenterResource::make($this->radiologyCenter),
            'provider_data'=>RadiologyResource::make($this->radiology),

        ];
    }
}
