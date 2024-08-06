<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthDoctorResource extends JsonResource
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
            'image'=>get_file($this->image),
            'is_popular'=>$this->is_popular,
            'location'=>$this->location,
            'about'=>$this->getTranslation('about', session_lang()),
            'type'=>$this->type,
            'token'=>$this->token,
            'specialization'=>new SpecializationResource($this->whenLoaded('specialization')),
            'times' => ProviderTimeResource::collection($this->whenLoaded('times')),

        ];
    }
}
