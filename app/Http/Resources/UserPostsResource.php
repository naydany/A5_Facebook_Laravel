<?php

namespace App\Http\Resources\UserPostsResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Post;

class UserPostsResource extends JsonResource
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
            'posts_numbers' => Post::where('user_id', $this->id)->count(),
            'posts_content'=> Post::where('user_id', $this->id)->get(),
        ];
    }
}
