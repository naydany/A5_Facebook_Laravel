<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AddFreindController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeCommentController;

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
    Route::post('/change_password',[AuthController::class,'change_password'])->middleware('auth:sanctum');

    Route::get('/user/post', [AuthController::class, 'user_posts']);
    Route::get('/user/post/{id}', [AuthController::class, 'show_user_posts']);

});

Route::post('/addlike',[LikesController::class,'addLike'])->middleware('auth:sanctum');

// group profile
Route::group([
   'middleware' => ['auth:sanctum']
]
, function () {
    Route::get('/profile/detail', [ProfileController::class, 'profile'])->name('profile.view');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

//Comment to posts
Route::prefix('auth')->group(function(){
    Route::get('/comment/list', [CommentController::class, 'index']);
    Route::post('/comment/create', [CommentController::class, 'store']);
    Route::put('/comment/update/{id}', [CommentController::class, 'updateComment']);
    Route::delete('/comment/delete/{id}', [CommentController::class, 'deleteComment']);
});

// create posts
Route::prefix('auth')->group(function(){
    Route::get('/post', [PostController::class,'index']);
    Route::get('/post/show/{id}', [PostController::class, 'show']);
    Route::post('/post/create', [PostController::class, 'store']);
    Route::put('/post/edit/{id}', [PostController::class, 'update']);
    Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
    // Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::post('/send-request', [AddFreindController::class, 'sendRequest']);