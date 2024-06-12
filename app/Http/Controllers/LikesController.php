<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LikesController extends Controller
{
   public function addLike(Request $request){

      $request->Validated([
        'post_id'=> 'require',
      ]);

      $like = Likes::created([
        'emoji_id'=>$request->emoji_id,
        'post_id'=>auth()->user()->id,
        'user_id'=>$request->user_id,
      ]);
       
      try{
          return response()->json(['message'=>'liked','like'=>$like]);  
      }catch(Exception $e){
        return $e;
      }
   }
   
}
