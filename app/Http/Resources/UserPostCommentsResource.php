<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
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
        $user = $request->user();

        $likesCount = NULL;
        $isUserLike = 0;
        $postCount = NULL;

        if(!is_null($this->likes)){
            $likesCount = $this->likes->where('post_like',1)->count();

            $isUserLikeData = $this->likes->where('user_id',$user->id)->where('post_id',$this->id)->where('post_like',1)->first();
            if($isUserLikeData){
                $isUserLike = 1;
            }
        }

        if(!is_null($this->comments)){
            $postCount = $this->comments->count();
        }

        return [
            'id' => $this->id,
            'post' => $this->post,
            'post_image' => $this->media?->isNotEmpty() ? $this->media?->last()->getFullUrl() : NULL,
            'post_by' => $this->user?->name ?? NULL,
            'user_profile_url' => $this->user?->media->isNotEmpty() ? $this->user?->media->last()->getFullUrl() : NULL,
            'is_user_like' => $isUserLike,
            'post_likes' => $likesCount,
            'post_comments_count' => $postCount,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'post_comments' => !is_null($this->comments) ? PostCommentsResource::collection($this->comments) : NULL,

        ];
    }
}
