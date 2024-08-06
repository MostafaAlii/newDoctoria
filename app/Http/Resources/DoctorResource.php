<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'nickname'=>$this->nickname,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'gender'=>$this->gender,
            'weight'=>$this->weight,
            'lang'=>$this->lang,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'image'=>get_file($this->image),
            'is_popular'=>$this->is_popular,
            'location'=>$this->location,
            'about'=>$this->getTranslation('about', session_lang()),
            'medical_certification'=>unserialize($this->medical_certification) !== false ? unserialize($this->medical_certification) : [],
            'service_price_online'=>$this->service_price_online,
            'service_price_home'=>$this->service_price_home,
            'experience_years'=>$this->experience_years,
            'specialization'=>new SpecializationResource($this->whenLoaded('specialization')),
            //'doctor_branch'=>new DoctorBranchResource($this->whenLoaded('doctor_branch')),
            'doctor_branch' => DoctorBranchResource::collection($this->whenLoaded('doctor_branch')),
            'times' => ProviderTimeResource::collection($this->whenLoaded('times')),

        ];
    }
}
