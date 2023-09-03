<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $todayDate = Carbon::parse(now())->toDateString();
        $isActiveAppointment = 0;

        if ($this->appointment_date == $todayDate) {
            $isActiveAppointment = 1;
        }

        $doctorName = NULL;
        if($this->doctor){
            if(!is_null($this->doctor?->first_name) && !is_null($this->doctor?->last_name)){
                $doctorName = $this->doctor?->first_name .' '. $this->doctor?->last_name;
            }else{
                $doctorName = $this->doctor?->first_name;
            }
        }

        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $doctorName,
            'apointmnet_date' => $this->appointment_date,
            'is_appointment_active' => $isActiveAppointment,
            'slot_id' => $this->slot_id,
            'slot_time' => $this?->slot?->slot_time ?? NULL
        ];
    }
}
