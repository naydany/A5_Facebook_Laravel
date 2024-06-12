<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Likes extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'emoji_id',
        'post_id',
        'user_id'
    ];
}
