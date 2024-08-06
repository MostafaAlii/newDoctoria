<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title'=>$this->title,
            'body'=>$this->body,
            'type'=>$this->type,
            'date'=>$this->date,
            'is_read'=>(int)$this->is_read,
            'foreign_id'=>$this->foreign_id,
            'created_at'=>$this->created_at,
            'mainService'=>new MainServiceResource($this->whenLoaded('mainService')),


        ];
    }
}
