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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');


// Group of Profile
Route::group([
   'middleware' => ['auth:sanctum']
]
, function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.view');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/comment/list', [CommentController::class, 'index']);
Route::post('/comment/create', [CommentController::class, 'store']);
Route::put('/comment/update/{id}', [CommentController::class, 'updateComment']);
Route::delete('/comment/delete/{id}', [CommentController::class, 'deleteComment']);



// Group of Comment
// Route::group([
//    'middleware' => ['auth:sanctum']
// ]
// , function () {
//     Route::get('/comment/list', [CommentController::class, 'index']);
//     Route::post('/comment/create', [CommentController::class, 'comment']);
//     Route::post('/comment/update', [CommentController::class, 'updateComment']);
//     Route::post('/comment/delete', [CommentController::class, 'deleteComment']);
// });