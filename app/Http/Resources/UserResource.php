<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'profile_image' => $this->profile_image,
            'posts_numbers' => Post::where('user_id', $this->id)->count(),
            'comments_numbers' => Comment::where('user_id', $this->id)->count(),
            'comments_content'=> Comment::where('user_id', $this->id)->get(),
        ];
    }
}
