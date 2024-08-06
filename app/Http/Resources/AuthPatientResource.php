<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthPatientResource extends JsonResource
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
            'image'=>get_file($this->image),
            'type'=>$this->type,
            'token'=>$this->token,
            'nationality'=>new NationalityResource($this->whenLoaded('nationality')),
            'city'=>new CityResource($this->whenLoaded('city')),

        ];
    }
}
