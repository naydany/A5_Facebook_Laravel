<?php

namespace App\Http\Controllers\ChangePassword;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class verifyCodeController extends Controller
{
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->code == $request->code ) {

            return response()->json(['message' => 'Code verified successfully.','data'=>true], 200);
        }

        return response()->json(['message' => 'Invalid or expired code.','data'=>false], 400);
    }
}

