<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NationalityResource extends JsonResource
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
            'name'=>$this->getTranslation('name', session_lang()),
            'nickname'=>$this->getTranslation('nickname', session_lang()),
            'phone_code'=>$this->phone_code,
            'country_code'=>$this->country_code,
            'country_name'=>$this->getTranslation('country_name', session_lang()),

        ];
    }
}
