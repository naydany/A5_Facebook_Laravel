<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\ShowUserPostsResource;
use App\Http\Resources\UserPostsResource\UserPostsResource;


class AuthController extends Controller
{

    
    
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user_exist = User::where('email', $request->email)->first();
        if($user_exist){
            return response([
                'message' => "Email Already Exist !",
                'success' => false,
            ]);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(20),

        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response([
            'message' => "Create has been success",
            'success' => true,
            'access_token'  => $token,
            'user' => $user
        ]);
    }
    
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:255',
            'password'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
 
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User successfully logged out',
        ],200);
    }
    
    public function index(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions();
        $roles = $user->getRoleNames();
        return response()->json([
            'message' => 'Login success',
            'data' =>$user,
        ]);
    }
    public function user_posts()
    {
        $users = User::all();
        try{
            return response()->json(['data' => UserPostsResource::collection($users), 'success'=>true, 'message'=>'get user post successfully', 'status'=>200]);
        }catch (\Exception $e){
            return response()->json(['data' => $e->getMessage(),'success'=>false,'message'=>$e->getMessage(),'status'=>404]);
        }
    }
    public function show_user_posts(string|int $id)
    {
        try{
            $user = User::findOrFail($id);
            return response()->json(['data' => new ShowUserPostsResource($user), 'success'=>true, 'message'=>'get user post successfully', 'status'=>200]);
        }catch (\Exception $e){
            return response()->json(['data' => $e->getMessage(),'success'=>false,'message'=>$e->getMessage(),'status'=>404]);
        }
    }
}
