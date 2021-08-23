<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        $page = $request->page;
        $posts = Post::where('id','>' ,'0')->orderBy('id','desc')->with(['images','author.followings','author.followers','likes','comments.author'])->skip($page*5)->limit(5)->get();
        if($posts)
            return $posts;
    }

    public function getUserPosts(Request $request)
    {
        $userId = $request->user;
        return User::find($userId)->posts()->orderBy('id','desc')->with(['images','author.followings','author.followers'])->get();
    }

    public function create(Request $request)
    {
        $page = 0;

        $this->validate($request,[
            'location' => 'required',
            'postImages' => 'required'
        ]);
        
        $post = Post::create([
            'user_id' => $request->user,
            'location' => $request->location,
            'desc' => $request->desc
        ]);

        foreach($request->postImages as $img)
        {
            PostImage::create([
                'post_id' => $post->id,
                'img' => $img['name']
            ]);
        }
        return $post->with(['images','author.followings','author.followers','likes','comments.author'])->get();
        Post::where('id','>' ,'0')->orderBy('id','desc')->with(['images','author.followings','author.followers','likes','comments.author'])->skip($page*5)->limit(5)->get();
        // return Post::where('id','>' ,'0')->orderBy('id','desc')->with(['images','author'])->get();
    }

    public function like(Request $request)
    {
        $post = Post::find($request->postID);
        $user = User::find($request->user);
        $isPostLiked = $post->isLikedBy($user);
        if($isPostLiked == true)
        {
            $post->disLike($user,false);
        }
        else
        {
            $post->like($user,true);
        }
        
        return !$isPostLiked;
    }

    public function checkIfLiked(Request $request)
    {
        $post = Post::find($request->postID);
        $user = User::find($request->user);
        return $post->isLikedBy($user);
    }

    public function comment(Request $request)
    {
        return Comment::create([
            'user_id' => $request->user,
            'post_id' => $request->postID,
            'comment' => $request->comment
        ])->with('author')->get();
    }

}
