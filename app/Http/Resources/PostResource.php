<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LikeResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'image' => $this->image,
            'video' => $this->video,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'likes' => LikeResource::collection($this->likes()->get()),
            'like_count' => $this->Likes->count(),
            'comment'=> CommentResource::collection($this->comment)
        ];
    }
}
