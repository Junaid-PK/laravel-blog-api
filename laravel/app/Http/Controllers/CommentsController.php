<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;

class CommentsController extends Controller
{
    public function getComments(Request $request){        
        $post = Post::find($request->id);
        if (!$post){
            return response()->json(['message' => 'No Post Found'], 404);    
        }
        $postComments = Post::with('comments')->where('id' ,$request->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['comments' => $postComments], 200);
    }

    public function postComment(Request $request){
        $request->validate([
            'message'=> 'required',
        ]);
        $post = Post::find($request->id);
        if (!$post){
            return response()->json(['message' => 'No Post Found'], 404);    
        }
        $message = $request->message;
        // $user_id = auth()->id();
        $post_id = $post->id;
        $comment = Comment::create([
            'message' => $message,
            'user_id' => $request->user_id,
            'post_id' => $post_id
        ]);
        if(!$comment){
            return response()->json([
                'message' => 'Something went Wrong'
            ],500);
        }

        return response()->json([
            'message' => 'Comment Created Successfully'
        ],200);
    }

}
