<?php

namespace App\Http\Controllers\ChangPassword;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Exception;

class ForgetPassword extends Controller
{
    public function sendWelcomeEmail()
    {
        $toEmail = 'programmingfields.com@gmail.com';
        $message = [
            'title' => 'Welcome to Programming Fields',
            'body' => 'Thank you for signing up. We are glad to have you with us.'
        ];
        $subject = 'Welcome email in Laravel Using Gmail';

        try {
            Mail::to($toEmail)->send(new WelcomeMail($message, $subject));
            return response()->json(['message' => 'Email sent successfully!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // public function sendWelcomeEmail()
    // {
    //     $MailMessage = 'We\'re glad to have you with us!';

    //     Mail::to('recipient@example.com')->send(new WelcomeMail($message,$request));

    //     return 'Email sent successfully';
    // }
}
