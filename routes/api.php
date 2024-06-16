<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePassword\ForgetPassword;
use App\Http\Controllers\ChangePassword\resetPasswordController;
use App\Http\Controllers\ChangePassword\verifyCodeController as ChangePasswordVerifyCodeController;
use App\Http\Controllers\LikesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeCommentController;
use App\Http\Controllers\AddFreindController;
use App\Http\Controllers\TestController;

// use App\Http\Controllers\LikeCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('/forgot_password',[ForgetPassword::class,'sendWelcomeEmail']);
    Route::post('/verify-code',[ChangePasswordVerifyCodeController::class,'verifyCode'])->middleware('auth:sanctum');
    Route::post('/change_password',[resetPasswordController::class,'changePassword'])->middleware('auth:sanctum');

    Route::get('/user/post', [AuthController::class, 'user_posts']);
    Route::get('/user/post/{id}', [AuthController::class, 'show_user_posts']);

});

// group profile
Route::prefix('profile')->group(function(){
    Route::group([
       'middleware' => ['auth:sanctum']
    ]
    , function () {
        Route::get('/detail', [ProfileController::class, 'profile'])->name('profile.view');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    });
});

//Comment to posts
Route::prefix('comment')->group(function(){
    Route::get('/list', [CommentController::class, 'index']);
    Route::post('/create', [CommentController::class, 'store']);
    Route::put('/update/{id}', [CommentController::class, 'updateComment']);
    Route::delete('/delete/{id}', [CommentController::class, 'deleteComment']);
});

// create posts
Route::prefix('post')->group(function(){
    Route::get('/list', [PostController::class,'index']);
    Route::get('/show/{id}', [PostController::class, 'show']);
    Route::post('/create', [PostController::class, 'store']);
    Route::put('/edit/{id}', [PostController::class, 'update']);
    Route::delete('/delete/{id}', [PostController::class, 'destroy']);

    Route::post('/add-like',[LikesController::class,'addLike'])->middleware('auth:sanctum');
});

// request to friends
// Route::post('/send-request', [AddFreindController::class, 'sendRequest']);
// Route::get('/Friends/list/{id}', [AddFreindController::class, 'Friends']);

Route::prefix('auth')->group(function(){
    Route::post('/friend-request', [AddFreindController::class, 'sendRequest'])->middleware('auth:sanctum');
    Route::post('/friend-request/confirm/{id}', [AddFreindController::class, 'confirmRequest'])->middleware('auth:sanctum');
    Route::delete('/friend-request/{id}', [AddFreindController::class, 'deleteRequest'])->middleware('auth:sanctum');
    Route::get('/friends/list', [AddFreindController::class, 'friendList'])->middleware('auth:sanctum');
});
    
