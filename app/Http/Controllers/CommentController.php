<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
class CommentController extends Controller
{
    //
    function store(Request $request)
    {
        $comment =  Comment::create([
            "content"=> $request->comment,
            "post_id"=> $request->post_id,
            "user_id"=>$request->comment_creator,
        ]);
        return redirect()->route("posts.show",$request->post_id);
    }
}
