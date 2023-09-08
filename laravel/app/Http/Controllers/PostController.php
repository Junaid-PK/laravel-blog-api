<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\PostsService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPosts()
    {
        return response()->json(['posts' => Post::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createPost(CreatePostRequest $request, PostsService $postService)
    {        
        $data = $request->validated();
        return $postService->createNewPost($data);
    }

    /**
     * Display the specified resource.
     */
    public function getPost(Request $request)
    {
        return response()->json(['post' => $request->post_id]);
    }

    public function deletePost(Request $request, PostsService $postService)
    {
        return $postService->deletePost($request);
    }
}
