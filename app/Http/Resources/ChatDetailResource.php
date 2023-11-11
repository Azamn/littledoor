<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatDetailResource extends JsonResource
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
            'chat_id' => $this->id,
            'patient_id' => $this->sender_id,
            'doctor_id' => $this->receiver_id,
            'patient_name' => $this->patient?->user?->name ?? NULL,
            'patient_image_url' => $this->patient?->user?->media?->isNotEmpty() ? $this->patient?->user?->media?->last()->getFullUrl() : NULL,
            'doctor_name' => $this->doctor?->user->name ?? NULL,
            'doctor_image_url' => $this->doctor?->user?->media?->isNotEmpty() ? $this->doctor?->user?->media?->last()->getFullUrl() : NULL,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
