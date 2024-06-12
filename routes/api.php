<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
Route::get('/user/post', [AuthController::class, 'user_posts']);
Route::get('/user/post/{id}', [AuthController::class, 'show_user_posts']);


Route::get('/post', [PostController::class,'index']);
Route::get('/post/show/{id}', [PostController::class, 'show']);
Route::post('/post/create', [PostController::class, 'store']);
Route::put('/post/edit/{id}', [PostController::class, 'update']);
Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');