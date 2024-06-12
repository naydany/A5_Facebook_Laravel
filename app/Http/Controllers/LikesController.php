<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LikesController extends Controller
{
   public function addLike(Request $request){

      $request->Validated([
        'post_id'=> 'require',
      ]);

      Likes::created([
        'emoji_id'=>$request->emoji_id,
        'post_id'=>auth()->user()->id,
        'user_id'=>$request->user_id,
      ]);
       
      return response('liked');
   }
   
}
