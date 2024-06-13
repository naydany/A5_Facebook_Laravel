<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        
        // return $request;
        $dataValidator = Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'nullable|string',
            'images' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'user_id' => 'required|integer|string|exists:users,id',
        ]);
        
        if ($dataValidator->fails()){
            return response()->json([
                'success'=> false,
                'message'=> $dataValidator->errors(),
                'status'=>404
            ]);
        }

        $img = $request->images;
        $ext = $img->getClientOriginalExtension();
        $imageName = time().'.'.$ext;
        $img->move(public_path('/store_files/images/'), $imageName);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->images = $imageName;
        $post->user_id = $request->user_id;
        $post->save();
        return response()->json([
            'data' => $post, 
            'image_path' => asset('/store_files/images/'. $imageName),
            'success' => true,
            'message' => 'Post created successfully',
            'status' => 200
        ]);  
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string|int $id)
    {
        $post = Post::findOrFail($id);
    
        // Validate the request data
        $dataValidator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'images' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'user_id' => 'required|integer|exists:users,id',
        ]);
    
        if ($dataValidator->fails()) {
            return response()->json([
                'success'=> false,
                'message'=> $dataValidator->errors(),
                'status'=>404
            ]);
        }
    
        try {
            // Handle image upload if a new image is provided
            if ($request->hasFile('images')) {
                // Delete the old image if it exists
                if ($post->images && file_exists(public_path('/store_files/images/' . $post->images))) {
                    unlink(public_path('/store_files/images/' . $post->images));
                }
    
                $img = $request->images;
                $ext = $img->getClientOriginalExtension();
                $imageName = time() . '.' . $ext;
                $img->move(public_path('/store_files/images/'), $imageName);
    
                $post->images = $imageName;
            }
    
            // Update the post with validated data
            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = $request->user_id;
            $post->save();
    
            return response()->json([
                'data'=> $post,
                'image_path' => asset('/store_files/images/' . $post->images),
                'success' => true,
                'message' => 'Post updated successfully',
                'status'=>200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data'=> $e->getMessage(),
                'success'=> false,
                'message'=> $e->getMessage(),
                'status'=>404
            ]);
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