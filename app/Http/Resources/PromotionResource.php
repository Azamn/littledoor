<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $startDate = NULL;
        $endDate = NULL;

        if (!is_null($this->start_date)) {
            $startDate = Carbon::parse($this->start_date)->format('d-m-Y');
        }

        if (!is_null($this->end_date)) {
            $endDate = Carbon::parse($this->end_date)->format('d-m-Y');
        }


        return [

            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_always' => $this->is_always,
            'image_url' => $this->media->isNotEmpty() ? $this->media->last()->getFullUrl() : NULL,

        ];
    }
}
