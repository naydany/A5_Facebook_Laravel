<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Expr\FuncCall;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'auth_id',
    ];

    public function author(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function getLikes():HasMany
    {
        return $this->hasMany(Likes::class,'post_id');
    }
}

