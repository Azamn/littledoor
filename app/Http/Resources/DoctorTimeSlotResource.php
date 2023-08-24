<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorTimeSlotResource extends JsonResource
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
            'id' => $this->id,
            'days_id' => $this->master_days_id,
            'day' => $this->days?->name,
            'slot_id' => $this->time_slot_id,
            'slot_time' => $this->timeSlot?->slot_time ?? NULL,
        ];
    }
}
