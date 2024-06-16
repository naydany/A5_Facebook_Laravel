<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Swagger(
 *   basePath="/api",
 *   @OA\Info(
 *     title="Post API",
 *     version="1.0.0",
 *     description="API documentation for posts"
 *   )
 * )
 */

/**
 * @OA\Tag(
 *     name="Post",
 *     description="Operations about posts"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/post/list",
     *     summary="Get a list of posts",
     *     tags={"Post"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        try {
            $posts = Post::all();
            return response()->json(['data' => PostResource::collection($posts), 'success' => true, 'message' => 'Retrieved all posts successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'success' => false, 'message' => 'Failed to retrieve posts', 'status' => 404]);
        }
    }


     /**
 * @OA\Post(
 *     path="/api/post/store",
 *     summary="Store a new post",
 *     tags={"Post"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     description="Title of the post",
 *                     example="Event"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="string",
 *                     description="Content of the post",
 *                     example="Party"
 *                 ),
 *                 @OA\Property(
 *                     property="images",
 *                     type="string",
 *                     format="binary",
 *                     description="Image file"
 *                 ),
 *                 @OA\Property(
 *                     property="user_id",
 *                     type="integer",
 *                     description="ID of the user creating the post",
 *                     example=2
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */
    public function store(Request $request)
    {
        $dataValidator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'nullable|string',
            'images' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($dataValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $dataValidator->errors(),
                'status' => 404
            ]);
        }

        $img = $request->images;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path('/store_files/images/'), $imageName);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->images = $imageName;
        $post->user_id = $request->user_id;
        $post->save();

        return response()->json([
            'data' => $post,
            'image_path' => asset('/store_files/images/' . $imageName),
            'success' => true,
            'message' => 'Post created successfully',
            'status' => 200
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/post/{id}",
     *     summary="Get a specific post",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Post retrieved successfully"),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function show(string|int $id)
    {
        try {
            $post = Post::find($id);
            if ($post) {
                return response()->json(['data' => $post, 'success' => true, 'message' => 'Post retrieved successfully', 'status' => 200]);
            } else {
                return response()->json(['data' => null, 'success' => false, 'message' => 'Post not found', 'status' => 404]);
            }
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'success' => false, 'message' => 'Failed to retrieve post', 'status' => 404]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/post/{id}",
     *     summary="Update a post",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Post Title"),
     *             @OA\Property(property="content", type="string", example="Updated Post Content"),
     *             @OA\Property(property="images", type="string", format="binary"),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Post updated successfully"),
     *     @OA\Response(response=404, description="Post not found"),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function update(Request $request, string|int $id)
    {
        $post = Post::findOrFail($id);

        $dataValidator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'images' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($dataValidator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $dataValidator->errors(),
                'status' => 404
            ]);
        }

        try {
            if ($request->hasFile('images')) {
                if ($post->images && file_exists(public_path('/store_files/images/' . $post->images))) {
                    unlink(public_path('/store_files/images/' . $post->images));
                }

                $img = $request->images;
                $ext = $img->getClientOriginalExtension();
                $imageName = time() . '.' . $ext;
                $img->move(public_path('/store_files/images/'), $imageName);

                $post->images = $imageName;
            }

            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = $request->user_id;
            $post->save();

            return response()->json([
                'data' => $post,
                'image_path' => asset('/store_files/images/' . $post->images),
                'success' => true,
                'message' => 'Post updated successfully',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'success' => false,
                'message' => 'Failed to update post',
                'status' => 404
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/post/{id}",
     *     summary="Delete a post",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Post deleted successfully"),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function destroy(string|int $id)
    {
        $post = Post::findOrFail($id);
        try {
            $post->delete();
            return response()->json(['success' => true, 'message' => 'Post deleted successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'success' => false, 'message' => 'Failed to delete post', 'status' => 404]);
        }
    }
}
