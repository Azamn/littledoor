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

        if($this->doctorWorkMapping){
            $category = [];
            foreach($this->doctorWorkMapping as $wmp){
                array_push($category,$wmp->category?->name);
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->user?->name ?? NULL,
            'email' => $this->user?->email ?? NULL,
            'image' => $this->user?->media?->isNotEmpty() ? $this->user?->media->last()->getFullUrl() : NULL,
            'city' => $this->city?->city_name,
            'state' => $this->city?->state?->state_name,
            'total_year_of_experience' => $this->total_no_of_years_experience ?? NULL,
            'category_name' => implode(',',$category),
            'skills' => $this->doctorSkillsMapping ? DoctorSkillsResource::collection($this->doctorSkillsMapping) : NULL,
            'appreciation' => $this->doctorAppreciationMapping ? DoctorAppeciationResource::collection($this->doctorAppreciationMapping) : NULL,
            'time_slot' => $this->timeSlot ? DoctorTimeSlotResource::collection($this->timeSlot) : NULL

        ];
    }
}
