<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionMappingResource extends JsonResource
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
            'sub_category_question_mapping_id' => $this?->sub_category_question_mapping_id,
            'option_id' => $this?->option_id,
            'option_name' => $this?->option?->name ?? NULL
        ];
    }
}
