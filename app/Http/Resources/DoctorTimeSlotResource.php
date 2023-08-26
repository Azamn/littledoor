<?php

namespace App\Http\Resources;

use App\Models\MasterTimeSlot;
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

        $slotsData = [];

        $slotIds = explode(",", $this->time_slot_id);
        if ($slotIds) {

            foreach ($slotIds as $slotId) {

                $timeSlot = MasterTimeSlot::where('id', $slotId)->first();

                if ($timeSlot) {
                    $data = [
                        'slot_id' => $timeSlot->id,
                        'slot_time' => $timeSlot->slot_time,
                    ];
                    array_push($slotsData, $data);
                }
            }
        }

        return [
            'days_id' => $this->master_days_id,
            'day' => $this->days?->name,
            'slots' => $slotsData ?? NULL,
        ];
    }
}
