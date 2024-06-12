<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

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
            // 'user_id' => $this->user->name,
            'like' => $this->like,
            'body' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => new UserResource($this->user),
            'total_comments' => $this->total_comments,
            'total_like' => $this->total_like,
            
        ];
    }
}
