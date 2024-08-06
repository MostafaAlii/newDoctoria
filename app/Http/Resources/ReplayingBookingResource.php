<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplayingBookingResource extends JsonResource
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
            'desc'=>$this->desc,
            'doctor'=>new DoctorResource($this->whenLoaded('doctor')),
            'replyingBookingDiagnoses' => ReplayingBookingDiagnosisResource::collection($this->whenLoaded('replyingBookingDiagnoses')),
            'replyingBookingAnalysis' => ReplayingBookingAnalysisResource::collection($this->whenLoaded('replyingBookingAnalysis')),
            'replyingBookingMedicals' => ReplayingBookingMedicalResource::collection($this->whenLoaded('replyingBookingMedicals')),
            'replyingBookingRadiology' => ReplayingBookingRadiologyResource::collection($this->whenLoaded('replyingBookingRadiology')),


        ];
    }
}
