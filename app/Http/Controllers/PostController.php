<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $posts = Post::all();
            return response()->json(['data'=> PostResource::collection($posts), 'success' => true, 'message' => 'get all posts successfully', 'status'=>200]);
        }catch(\Exception $e){
            return response()->json(['data'=> $e->getMessage(), 'success'=> false, 'message'=> $e->getMessage(),'status'=>404]);
        }
    }


    /*
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        //
        $post = new Post();
        $data = $request->validated();
        try{
            $post->create($data);
            return response()->json(['data'=> $data, 'success' => true, 'message' => 'create post successfully', 'status'=>200]);
        }catch(\Exception $e){
            return response()->json(['data'=> $e->getMessage(), 'success'=> false, 'message'=> $e->getMessage(),'status'=>404]);
        }
    }

    /*
     * Display the specified resource.
     */
    public function show(string|int $id)
    {
        //
        try{
            $post = Post::find($id);
            return response()->json(['data'=> $post, 'success' => true, 'message' => 'get post successfully', 'status'=>200]);
        }catch(\Exception $e){
            return response()->json(['data'=> $e->getMessage(), 'success'=> false, 'message'=> $e->getMessage(),'status'=>404]);
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit(request $request, string|int $id)
    {
        //
       
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string|int $id)
    {
        //
        $post = Post::findOrFail($id);
        $data = $request->validated();
        try{
            $post->update($data);
            return response()->json(['data'=> $post, 'success' => true, 'message' => 'update post successfully', 'status'=>200]);
        }catch(\Exception $e){
            return response()->json(['data'=> $e->getMessage(), 'success'=> false, 'message'=> $e->getMessage(),'status'=>404]);
        }
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy(string|int $id)
    {
        //
        $post = Post::findOrFail($id);
        try{
            $post->delete();
            return response()->json(['success' => true, 'message' => 'delete post successfully', 'status'=>200]);
        }catch(\Exception $e){
            return response()->json(['data'=> $e->getMessage(), 'success'=> false, 'message'=> $e->getMessage(),'status'=>404]);
        }
    }
}