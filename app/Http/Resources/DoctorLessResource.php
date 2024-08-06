<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorLessResource extends JsonResource
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
            'image'=>get_file($this->image),
            'is_popular'=>$this->is_popular,
            'location'=>$this->location,
        ];
    }
}
