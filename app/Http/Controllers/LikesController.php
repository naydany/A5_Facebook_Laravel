<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LikesController extends Controller
{
  public function addLike(Request $request)
  {
      // Validate the request
      $request->validate([
          'post_id' => 'required|integer|exists:posts,id', 
      ]);

      $liked = Likes::where('post_id', $request->post_id)->where('user_id',Auth()->user()->id)->first();
      if ($liked){
          $liked->delete();
          return response()->json(['message' => 'Unliked'], 201);
      }

      Likes::create([
          'emoji_id' => $request->emoji_id,
          'post_id' => $request->post_id,
          'user_id' => auth()->user()->id, 
      ]);
      try {

          return response()->json(['message' => 'liked'], 201);
      } catch (Exception $e) {
          return response()->json(['error' => $e->getMessage()], 500);
      }
  }
   
}
