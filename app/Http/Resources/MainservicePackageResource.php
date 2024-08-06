<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainservicePackageResource extends JsonResource
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
            'count'=>(int)$this->count,
            'mainService'=>new MainServiceResource($this->whenLoaded('mainService')),
            'package'=>new PackageResource($this->whenLoaded('package')),
        ];
    }
}
