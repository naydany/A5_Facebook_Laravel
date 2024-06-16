<?php

namespace App\Http\Controllers\ChangePassword;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class resetPasswordController extends Controller
{
    //
    public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6|max:100',
        'confirm_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation fails',
            'error' => $validator->errors(),
        ], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'message' => 'User not found',
        ], 404);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'message' => 'Password successfully updated',
    ], 200);
}

}
