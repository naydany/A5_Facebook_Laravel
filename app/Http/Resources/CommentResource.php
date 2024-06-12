<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Post;
use App\Models\Likes;
use App\Models\Comment;

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
            'body' => $this->comment,
            'post_id' => $this->post_id,
            'like_id' => $this->like_id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'user_image' => $this->user->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'user_id' => new UserResource($this->user),
            'total_comment' => Comment::where('like_id', $this->like_id)->count(),
            'show_like' => new Likes(),
        ];
    }
}
