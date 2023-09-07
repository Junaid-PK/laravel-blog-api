<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::middleware('auth:sanctum')->get('/user/posts', function (Request $request) {
    $userPosts = User::with('posts')->get();
    return $userPosts;
});


// Authentication Routes
Route::group([UserController::class], function(){
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);        
});

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function(){
    // user related
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/user/delete', [UserController::class, 'remove']);
    Route::put('/user/update', [UserController::class, 'update']);

    // post related
    Route::resource('posts', PostController::class);
    Route::get('/post/{id}/comments', [CommentsController::class, 'getComments']);
    Route::post('/post/{id}/comment', [CommentsController::class, 'postComment']);
    Route::post('/post/delete', [PostController::class, 'remove']);
});