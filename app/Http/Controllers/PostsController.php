<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
class PostsController extends Controller
{
    function index(Request $request)
    {
        return view("posts.index", ["posts" => Post::paginate(15),"deletedPosts"=> Post::onlyTrashed()->paginate(5)]);
    }

    function create()
    {
        $users= User::all();
        return view("posts.create", ["users"=> $users]);
    }
    function store(Request $request)
    {
        $post =  Post::create([
            "title"=> $request->title,
            "description"=> $request->description,
            "user_id"=>$request->post_creator,
        ]);
        return to_route("posts.index");
    }

    function show($id)
    {
        $post = Post::find($id);
        if($post == null) {
            return response(redirect(url('/')), 404);
        }
        $comments = $post->comments;
        $users = User::all();
        return view("posts.show", ["id" => $id, "post" => $post,"comments"=>$comments,"users"=> $users]);
    }

    function edit($id)
    {
        $post = Post::find($id);
        if($post == null) {
            return response(redirect(url('/')), 404);
            // return to_route("posts",null,404);
        }
        $users = User::all();
        return view("posts.edit", ["post" => $post,"users"=> $users]);
    }
    function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id= $request->post_creator;
        $post->save();
        return to_route("posts.index");
    }
    function destroy($id){
        $post = Post::find($id);
        if($post == null) {
            return response(redirect(url("/")),404);
        }
        $post->delete();
        return to_route("posts.index");
    }

    function restore($id){
        $post = Post::withTrashed()->find($id);
        if($post == null) {
            return response(redirect(url("/")),404);
        }
        $post->restore();
        return to_route("posts.index");
    }
}

