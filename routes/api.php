<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/change_password',[AuthController::class,'change_password'])->middleware('auth:sanctum');

// Group of Profile
Route::group([
   'middleware' => ['auth:sanctum']
]
, function () {
    Route::get('/profile/detail', [ProfileController::class, 'profile'])->name('profile.view');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});


//Comment
Route::get('/comment/list', [CommentController::class, 'index']);
Route::post('/comment/create', [CommentController::class, 'store']);
Route::put('/comment/update/{id}', [CommentController::class, 'updateComment']);
Route::delete('/comment/delete/{id}', [CommentController::class, 'deleteComment']);
