<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    
    //----------register
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6|max:100'
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
    
        return response([
            'message' => "Create has been success",
            'success' => true,
            'user' => $user
        ]);
    }
    
    //-------------login
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:255',
            'password'  => 'required|min:6|max:100'
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


    //-----------logout
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User successfully logged out',
        ],200);
    }
    

    //-------------get infor user login
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

    // ---------- change_password
    public function change_password(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password'=>'required',
            'password' => 'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validations fails',
                'error' =>$validator->errors()
            ],422);
        }
        $user = $request->user();
        if(Hash::check($request->old_password,$user->password)){
            $user->update([
                'password'=>Hash::make($request->password)
            ]);
            return response()->json([
                'message' => 'Password successfull updated',
            ],400);
        }else{
            return response()->json([
                'message'=>'Old password does not matched',
            ],400);
        }
    }
}
