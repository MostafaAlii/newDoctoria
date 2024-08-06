<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>(int) $this->id,
            'type'=>$this->type,
            'from_time'=>$this->from_time,
            'to_time'=>$this->to_time,
            'day'=>new DayResource($this->day),
            'category'=>new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
