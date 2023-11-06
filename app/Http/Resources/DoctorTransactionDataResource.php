<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorTransactionDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $patientFullName = NULL;
        $patientIamge = NULL;
        $doctorIamge = NULL;
        $doctorFullName = NULL;

        if($this->patient){
            if(!is_null($this->patient?->first_name) && !is_null($this->patient?->last_name)){
                $patientFullName = $this->patient?->first_name .' '. $this->patient?->last_name;
            }else{
                $patientFullName =  $this->patient?->first_name;
            }

            if($this->patient->user){
                $patientIamge = $this->patient?->user?->media->isNotEmpty() ? $this->patient?->user?->media->last()->getFullUrl() : NULL;
            }
        }

        if($this->doctor){
            if(!is_null($this->doctor?->first_name) && !is_null($this->doctor?->last_name)){
                $doctorFullName = $this->doctor?->first_name .' '. $this->doctor?->last_name;
            }else{
                $doctorFullName =  $this->doctor?->first_name;
            }

            if($this->doctor->user){
                $doctorIamge = $this->doctor?->user?->media->isNotEmpty() ? $this->doctor?->user?->media->last()->getFullUrl() : NULL;
            }
        }



        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'transaction_number' => $this->transaction_number,
            'status' => $this->status,
            'patient_id' => $this->patient_id,
            'patient_name' => $patientFullName ?? NULL,
            'patient_image' => $patientIamge ?? NULL,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $doctorFullName ?? NULL,
            'doctor_image' => $doctorIamge ?? NULL,


        ];
    }
}
