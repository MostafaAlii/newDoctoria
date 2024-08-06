<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'privacy'=>$this->getTranslation('privacy', session_lang()),
            'about'=>$this->getTranslation('about', session_lang()),
            'facebook' => $this->facebook,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'google' => $this->google,
            'facebook_icon' => get_file($this->facebook_icon),
            'website_icon' => get_file($this->website_icon),
            'email_icon' => get_file($this->email_icon),
            'phone_icon' => get_file($this->phone_icon),
            'google_icon' => get_file($this->google_icon),
        ];
    }
}
