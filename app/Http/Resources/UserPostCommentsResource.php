<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPostCommentsResource extends JsonResource
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
            'post' => $this->post,
            'post_image' => $this->media?->isNotEmpty() ? $this->media?->last()->getFullUrl() : NULL,
            'post_comments' => !is_null($this->comments) ? PostCommentsResource::collection($this->comments) : NULL,

        ];
    }
}
