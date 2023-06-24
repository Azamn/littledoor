<?php

namespace App\Http\Resources;

use App\Http\Resources\OptionMappingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionWithOptionResource extends JsonResource
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
            'id' => $this?->id,
            'sub_category_id' => $this?->master_sub_category_id,
            'sub_category_name' => $this?->subCategory?->name ?? NULL,
            'question_id' => $this?->master_question_id,
            'question_name' => $this?->question?->name ?? NULL,
            'options' => $this?->optionMapping ? OptionMappingResource::collection($this?->optionMapping) : NULL,
        ];
    }
}
