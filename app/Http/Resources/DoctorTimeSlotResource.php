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

            $timeSlot = MasterTimeSlot::where('status',1)->get();

            foreach ($slotIds as $slotId) {

                $timeSlotData = $timeSlot->where('id',$slotId)->first();

                if ($timeSlotData) {
                    $data = [
                        'slot_id' => $timeSlotData->id,
                        'slot_time' => $timeSlotData->slot_time,
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
