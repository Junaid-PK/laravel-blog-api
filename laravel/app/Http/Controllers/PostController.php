<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();        
        return response()->json(['posts' => $post], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        // $userId = auth()->id();

        $posts = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            "image_url" => $request->image_url
        ]);

        if($posts){
            return response()->json([
                'message' => 'Post Created Successfully'
            ],200);
        }

        return response()->json([
            'message' => 'Something went Wrong'
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if(! $post){
            return response()->json(['message' =>'No post Found'], 404);
        }

        return response()->json(['message' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
