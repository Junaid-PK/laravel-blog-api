<?php
namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsService
{

    public function createNewPost(array $data)
    {
        $userId = auth()->id();

        $posts = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $userId,
            "image_url" => array_key_exists('image_url',$data)?$data['image_url']:'',
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


    public function deletePost(Request $request)
    {
        $id = $request->post_id;
        $post = Post::find($id);

        if(!$post){
            return response()->json(['message' => 'Post Not Found']);
        }

        $request = Post::where('id', $post->id)->delete();

        if(!$request){
            return response()->json(['message' => 'Something went wrong'],500);
        }

        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);
    }


}
?>