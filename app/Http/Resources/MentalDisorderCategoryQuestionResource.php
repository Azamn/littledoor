<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MentalDisorderCategoryQuestionResource extends JsonResource
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
            'mental_disorder_category_id' => $this->mental_disorder_category_id,
            'mental_disorder_category_name' => optional($this->mentalDisorderCategory)->name ?? NULL,
            'question' => $this->question,
        ];
    }
}
