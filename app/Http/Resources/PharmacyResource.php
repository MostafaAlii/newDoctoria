<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
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
            'desc'=>$this->getTranslation('desc', session_lang()),
            'about_us'=>$this->getTranslation('about_us', session_lang()),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'website_link' => $this->website_link,
            'rating_value' => $this->rating_value,
            'num_of_raters' => $this->num_of_raters,
            'service_price' => $this->service_price,
            'image'=>get_file($this->image),
            'work_from'=>$this->work_from,
            'work_to'=>$this->work_to,
            'location'=>$this->location,
        ];
    }
}
