<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDailyJournalResouce extends JsonResource
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
            'patient_id' => $this->patient_id ?? NULL,
            'doctor_id' => $this->doctor_id ?? NULL,
            'emotion_id' => $this->emotion_id,
            'emotion_name' => $this->emotion?->name,
            'emotion_url' => $this->emotion?->media?->isNotEmpty() ? $this->emotion?->media->last()->getFullUrl() : NULL,
            'journal_date' => Carbon::parse($this->journal_date)->format('d-m-Y'),
            'message' => $this->message,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
