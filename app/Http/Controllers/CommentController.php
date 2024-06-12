<?php

namespace App\Http\Controllers;

use App\Models\Comment;
// use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use Exception;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $comments = Comment::all();
        try{
            $comments = CommentResource::collection($comments);
            return response()->json(['comment'=>$comments, 'message'=>'Request comments successfully']);
        }catch(Exception $e){
            return response()->json([
               'comment' => false,
               'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        //
        $comment = Comment::create($request->all());
        try{
            $comment = new CommentResource($comment);
            return response()->json(['comment'=> true,'message'=>'User comments successfully']);
        }catch(Exception $e){
            return response()->json([
               'comment' => false,
               'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CommentRe $comment, string|int $id)
    {
        //
        $comment = Comment::findOrFail($id);
        try{
            $comment = new CommentResource($comment);
            return response()->json(['comment'=>$comment, 'message'=>'show comments successfully']);
        }catch(Exception $e){
            return response()->json([
               'comment' => false,
               'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateComment(CommentRequest $request, string|int $id)
    {
        //
        $comment = Comment::findOrFail($id);
        $comment->update($request->all());
        try{
            $comment = new CommentResource($comment);
            return response()->json(['comment'=>$comment, 'message'=>'Update comments successfully']);
        }catch(Exception $e){
            return response()->json([
               'comment' => false,
               'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteComment($id)
    {
        //
        $comment = Comment::findOrFail($id);
        $comment->delete();
        try{
            $comment = new CommentResource($comment);
            return response()->json(['message'=>'Delete comments successfully']);
        }catch(Exception $e){
            return response()->json([
               'comment' => false,
               'message' => $e->getMessage()
            ]);
        }

    }
}
