<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'type'=>$this->type,
            'day'=>$this->day,
            'time'=>$this->time,
            'desc'=>$this->desc,
            'price'=>$this->price,
            'status'=>$this->status,
            'specialization_type'=>$this->specialization_type,
            'created_at'=>$this->created_at->diffForHumans(),
            'mainService'=>new MainServiceResource($this->whenLoaded('mainService')),
            'patient'=>new PatientResource($this->whenLoaded('patient')),
            'docs' => BookingDocResourc::collection($this->whenLoaded('docs')),
            'doctor'=>new DoctorResource($this->whenLoaded('doctor')),
            'replying'=>new ReplayingBookingResource($this->whenLoaded('replying')),

        ];
    }
}
