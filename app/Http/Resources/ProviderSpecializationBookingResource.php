<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderSpecializationBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                =>(int)$this->id,
            'date'              =>$this->date,
            'from_time'         =>$this->from_time,
            'to_time'           =>$this->to_time,
            'description'       =>$this->description,
            'booking_type'      =>$this->booking_type,
            'referral_code'     =>$this->referral_code,
            'location'          =>$this->location,
            'status'            =>$this->status,
            'booking_type'      =>$this->booking_type,
            'other_phone_num'   =>$this->other_phone_num,
            'insurance_company_id'  =>new InsuranceCompanyResource($this->whenLoaded('insurace_company')),
            'patient'           =>new PatientResource($this->whenLoaded('patient')),
            'laboratory'        =>new LaboratoryResource($this->whenLoaded('laboratory')),
            'pharmacy'          =>new PharmacyResource($this->whenLoaded('pharmacy')),
            'radiology_center'  =>new RadiologyCenterResource($this->whenLoaded('radiology_center')),
            'hospital'          =>new HospitalResource($this->whenLoaded('hospital')),
            'docs'              => ProviderSpecializationBookingDocsResource::collection($this->whenLoaded('docs')),
            'created_at'        =>$this->created_at->diffForHumans(),
        ];
    }
}
