<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterDoctorDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $yearOfExperience = 0;

        if ($this->doctorWorkMapping) {
            $category = [];
            foreach ($this->doctorWorkMapping as $wmp) {
                $yearOfExperience += $wmp->year_of_experience;
                array_push($category, $wmp->category?->name);
            }
        }

        if (!is_null($this->languages_known)) {
            $languages = explode(",", $this->languages_known);
        }

        $sessionCharge = NULL;
        if ($this->doctorSession) {
            $sessionCharge = $this->doctorSession->session_amount;
        }

        return [
            'id' => $this->id,
            'name' => $this->user?->name ?? NULL,
            'email' => $this->user?->email ?? NULL,
            'image' => $this->user?->media?->isNotEmpty() ? $this->user?->media->last()->getFullUrl() : NULL,
            'city' => $this->city?->city_name,
            'state' => $this->city?->state?->state_name,
            'total_year_of_experience' => $yearOfExperience ?? NULL,
            'category_name' => implode(',', $category),
            'languages' => $languages ?? NULL,
            'doctor_session_charge' => $sessionCharge ?? NULL,
            'skills' => $this->doctorSkillsMapping ? DoctorSkillsResource::collection($this->doctorSkillsMapping) : NULL,
            'appreciation' => $this->doctorAppreciationMapping ? DoctorAppeciationResource::collection($this->doctorAppreciationMapping) : NULL,
            'time_slot' => $this->timeSlot ? DoctorTimeSlotResource::collection($this->timeSlot) : NULL

        ];
    }
}
