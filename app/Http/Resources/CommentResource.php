<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'post_id' => $this->post_id,
            'user_id' => $this->user->name,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            



            // 'comments' => CommentResource::collection($this->comments),
            // 'user' => new UserResource($this->user),
            // 'is_commented' => $this->comments->contains('user_id', $request->user()->id),
            // 'comments_count' => $this->comments->count(),
            // 'post' => new PostResource($this->post),
            // 'likes' => LikeResource::collection($this->likes),
            // 'likes_count' => $this->likes->count(),
            // 'is_liked' => $this->likes->contains('user_id', $request->user()->id),
        ];
    }
}
