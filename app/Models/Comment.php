<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Post;
use App\Models\Likes;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
        // 'like_id',
    ];

    public function user():belongsTo{
        return $this->belongsTo(User::class);
    }
    public function post():belongsTo{
        return $this->belongsTo(Post::class);
    }
    // public function likes():belongsTo{
    //     return $this->belongsTo(Likes::class);
    // }
}
