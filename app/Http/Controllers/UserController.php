<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Exception;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message'       => 'Login success',
            'data'  => $request->user(),
        ]);
    }

}
