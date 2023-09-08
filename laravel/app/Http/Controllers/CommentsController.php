<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Nette\Utils\Random;

class CommentsController extends Controller
{
    public function getComments(Request $request){        
        $post = Post::find($request->post_id);
        if (!$post){
            return response()->json(['message' => 'No Post Found'], 404);    
        }
        $postComments = Post::with('comments')->where('id' ,$post->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['comments' => $postComments], 200);
    }

    public function postComment(Request $request){
        $request->validate([
            'message'=> 'required',
        ]);
        $post = Post::find($request->post_id);
        if (!$post){
            return response()->json(['message' => 'No Post Found'], 404);    
        }
        $message = $request->message;
        $user_id = auth()->id();
        $user_name = User::select('name')->where('id', $user_id)->first();
        $post_id = $post->id;
        $comment = Comment::create([
            'message' => $message,
            'commented_by' => $user_name,
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


    public function commentAsGuest(Request $request){

        $request->validate([
            'message' => 'required'
        ]);
        $post = Post::find($request->post_id);
        if (!$post){
            return response()->json(['message' => 'No Post Found'], 404);    
        }
        $message = $request->message;
        $guest = 'Guest';
        $post_id = $post->id;
        $comment = Comment::create([
            'message' => $message,
            'commented_by' => $guest,
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
