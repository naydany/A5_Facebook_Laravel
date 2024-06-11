<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Support\Facades\Validator;
use File;

class ProfileController extends Controller
{
    public function profile()
    {
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'User profile retrieved successfully',
            // 'data' => $userData,
            'user_id' => auth()->user()->id
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'profile_image' => 'nullable|image|mimes:jpg,bmp,png',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                $old_path = public_path('uploads/profile_image/' . $user->profile_image);
                if (File::exists($old_path)) {
                    File::delete($old_path);
                }
            }

            $image = 'profile_image-' . time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('uploads/profile_image'), $image);
        } else {
            $image = $user->profile_image;
        }

        // Update the user's profile
        $user->update([
            'name' => $request->name,
            'profile_image' => $image
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Update profile user successfully',
            'data' => $user,
            'user_id' => auth()->user()->id
        ]);
    }
}
