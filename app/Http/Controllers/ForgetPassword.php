<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ForgetPassword extends Controller
{
    public function sendWelcomeEmail(Request $request)
    {
        $toEmail = 'dany.nay.2000@gmail.com';
        $message = 'Welcome to Programming Fields';
        $subject = 'Welcome email in Laravel Using Gmail';
        $randomCode = random_int(100000, 999999);

        try {
            Mail::to($toEmail)->send(new WelcomeMail($message, $subject,$randomCode));
            return response()->json(['message' => 'Email sent successfully!','code'=>$randomCode,'toEmail'=>$toEmail], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        $user = User::where('email', $request->email)->firstOrFail();
      
            $newUser = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'code' => $randomCode,
                'email_verified_at' => now(),
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'updated_at' => now(),
                'created_at' => $user->created_at,
            ];

            $user->update($newUser);
    }

}



