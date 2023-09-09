<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCommentsResource extends JsonResource
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
            'comment' => $this->comments,
            'comment_by' => $this->user?->name ?? NULL,
            'commented_user_profile_url' => $this->user?->media->isNotEmpty() ? $this->user?->media->last()->getFullUrl() : NULL,
            'commented_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
