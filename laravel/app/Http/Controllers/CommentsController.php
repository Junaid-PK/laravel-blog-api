<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentsService;

class CommentsController extends Controller
{
    public function getComments(Request $request, CommentsService $commentsService){        
        return $commentsService->getPostComment($request);
    }

    public function postComment(Request $request, CommentsService $commentsService){
        return $commentsService->postComment($request);
    }

    public function commentAsGuest(Request $request, CommentsService $commentsService){
        return $commentsService->commentAsGuest($request);
    }
}
