<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Guest Routes
Route::group([],
    function(){
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);        
        Route::post('/guest/post/comment', [CommentsController::class, 'commentAsGuest']);
        Route::get('/guest/posts', [PostController::class, 'getPosts']);
});


// User Related
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user/posts', [UserController::class,'getUserPosts']);
    Route::delete('/user/delete', [UserController::class, 'remove'])->middleware(['auth', 'App\Http\Middleware\CheckRole:admin']);
    Route::put('/user/update', [UserController::class, 'update'])->middleware(['auth', 'App\Http\Middleware\CheckRole:admin']);
    Route::get('/users', [UserController::class, 'getUsers'])->middleware(['auth', 'App\Http\Middleware\CheckRole:admin']);
});


// Post related
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/posts',[PostController::class, 'getPosts']);
    Route::get('/post',[PostController::class, 'getPost']);
    Route::post('/post/create',[PostController::class, 'createPost']);
    Route::delete('/post/delete',[PostController::class, 'deletePost'])->middleware(['auth', 'App\Http\Middleware\CheckRole:admin']);
    Route::get('/post/comments', [CommentsController::class, 'getComments']);
    Route::post('/post/comment', [CommentsController::class, 'postComment']);
});
