<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAddressResource extends JsonResource
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
            'address_type' => $this?->address_type,
            'address_line_1' => $this?->address_line_1 ?? NULL,
            'address_line_2' => $this?->address_line_2 ?? NULL,
            'pincode' => $this?->pincode ?? NULL,
            'city_id' => $this?->city_id ?? NULL,
            'city_name' => $this?->city?->city_name ?? NULL,
            'state_id' => $this?->state_id ?? NULL,
            'state_name' => $this?->state?->state_name ?? NULL
        ];
    }
}
