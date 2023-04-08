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
            'id' => $this->id,
            'name' => $this->name,
            'options' => $this->subCategoryQuestionOption ? OptionMappingResource::collection($this->subCategoryQuestionOption) : NULL,
        ];
    }
}
