<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAppeciationResource extends JsonResource
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
            'category_achieved' => $this?->category_achieved ?? NULL,
            'issue_date' => Carbon::parse($this?->issue_date)->format('d-m-Y'),
            'description' => $this?->description ?? NULL,
            'image_url' => $this->media->isNotEmpty() ? $this->media->where('collection_name','doctor-appreciation')->last()->getFullUrl() : NULL
        ];
    }
}
