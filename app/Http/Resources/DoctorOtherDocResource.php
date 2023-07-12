<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorOtherDocResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this?->id,
            'doctor_id' => $this?->doctor_id,
            'name' => $this?->name,
            'document' => $this?->media->isNotEmpty() ? $this->media->where('collection_name','doctor-appreciation')->last()->getFullUrl() : NULL
        ];
    }
}
