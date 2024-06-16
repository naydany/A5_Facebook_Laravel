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
            'post_name' => $this->post->title,
            'user_name' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'total_comment' => Comment::where('post_id', $this->post_id)->count(),
        ];
    }
}
