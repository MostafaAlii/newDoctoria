<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'email'=>$this->email,
            'nickname'=>$this->nickname,
            'gender'=>$this->gender,
            'postcode'=>$this->postcode,
            'phone'=>$this->phone,
            'refer_code'=>$this->refer_code,
            'address'=>$this->address,
            'location'=>$this->location,
            'image'=>get_file($this->image),
            'age'=>$this->age,
            'marital_status'=>$this->marital_status,
            'occupation'=>$this->occupation,
            'n_children'=>$this->n_children,
            'residence'=>$this->residence,
            'is_smoking'=>$this->is_smoking,
            'is_alcoholic'=>$this->is_alcoholic,
            'athlete'=>$this->athlete,
            'n_booking'=>count($this->bookings),
            'nationality'=>new NationalityResource($this->whenLoaded('nationality')),
            'city'=>new CityResource($this->whenLoaded('city')),

        ];
    }
}
