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
        $fullName = NULL;
        $iamge = NULL;

        if($this->patient){
            if(!is_null($this->patient?->first_name) && !is_null($this->patient?->last_name)){
                $fullName = $this->patient?->first_name .' '. $this->patient?->last_name;
            }else{
                $fullName =  $this->patient?->first_name;
            }

            if($this->patient->user){
                $iamge = $this->patient?->user?->media->isNotEmpty() ? $this->patient?->user?->media->last()->getFullUrl() : NULL;
            }
        }



        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'transaction_number' => $this->transaction_number,
            'status' => $this->status,
            'patient_name' => $fullName ?? NULL,
            'patient_image' => $iamge ?? NULL
        ];
    }
}
