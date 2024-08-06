<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            =>(int)$this->id,
            'date'          =>$this->date,
            'time'          =>$this->time,
            'from'          =>$this->from,
            'description'   =>$this->description,
            'booking_type'  =>$this->booking_type,
            'referral_code' =>$this->referral_code,
            'to'            =>$this->to,
            'location'      =>$this->location,
            'visit'         =>$this->visit,
            'price'         =>$this->price,
            'status'        =>$this->status,
            'patient'       =>new PatientResource($this->whenLoaded('patient')),
            'branch'        =>new DoctorBranchResource($this->whenLoaded('branch')),
            'docs'          => SpecializationBookingDocResource::collection($this->whenLoaded('docs')),
            'doctor'        =>new DoctorResource($this->whenLoaded('doctor')),
            'created_at'    =>$this->created_at->diffForHumans(),
        ];
    }
}
