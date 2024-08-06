<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelativeResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'is_smoking'=>$this->is_smoking,
            'is_alcoholic'=>$this->is_alcoholic,
            'gender'=>$this->gender,
            'type'=>$this->type,
            'birth_date'=>$this->birth_date,
            'address'=>$this->address,
            'id_number'=>$this->id_number,
            'nationality'=>new NationalityResource($this->whenLoaded('nationality')),
            'city'=>new CityResource($this->whenLoaded('city')),
            'country'=>new NationalityResource($this->whenLoaded('country')),

        ];
    }
}
