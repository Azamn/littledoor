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
        $doctorProfile = NULL;
        $doctorName = NULL;
        $category = [];
        if($this->doctor){
            if(!is_null($this->doctor?->first_name) && !is_null($this->doctor?->last_name)){
                $doctorName = $this->doctor?->first_name .' '. $this->doctor?->last_name;
            }else{
                $doctorName = $this->doctor?->first_name;
            }
            $doctorProfile = $this->doctor?->user?->media->isNotEmpty() ? $this->doctor?->user?->media->media->last()->getFullUrl() : NULL;

            if (!is_null($this->doctor?->doctorWorkMapping)) {
                foreach ($this->doctor?->doctorWorkMapping as $wmp) {
                    array_push($category, $wmp->category?->name);
                }
            }
        }

        $patientName = NULL;
        $patientProfile = NULL;

        if($this->patient){
            if(!is_null($this->patient?->first_name) && !is_null($this->patient?->last_name)){
                $patientName = $this->patient?->first_name .' '. $this->patient?->last_name;
            }else{
                $patientName = $this->patient?->first_name;
            }
            $patientProfile = $this->patient?->user?->media->isNotEmpty() ? $this->patient?->user?->media->media->last()->getFullUrl() : NULL;
        }

        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $doctorName,
            'doctor_profile' => $doctorProfile ?? NULL,
            'doctor_category' => $category,
            'apointmnet_date' => $this->appointment_date,
            'is_appointment_active' => $isActiveAppointment,
            'slot_id' => $this->slot_id,
            'slot_time' => $this?->slot?->slot_time ?? NULL,
            'patient_name' => $patientName ,
            'patient_profile' => $patientProfile
        ];
    }
}
