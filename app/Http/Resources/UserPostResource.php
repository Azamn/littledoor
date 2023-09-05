<?php

namespace App\Http\Resources;

use App\Http\Resources\PostCommentsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        $likesCount = NULL;

        if(!is_null($this->likes)){
            $likesCount = $this->likes->where('post_like',1)->count();
        }

        return [
            'id' => $this->id,
            'post' => $this->post,
            'post_image' => $this->media?->isNotEmpty() ? $this->media?->last()->getFullUrl() : NULL,
            'post_by' => $this->user?->name ?? NULL,
            'post_likes' => $likesCount,
            'post_comments' => !is_null($this->comments) ? PostCommentsResource::collection($this->comments) : NULL,
        ];
    }
}
