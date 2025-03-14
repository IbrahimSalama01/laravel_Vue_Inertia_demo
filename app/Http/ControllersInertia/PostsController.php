<?php
namespace App\Http\ControllersInertia;

use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostsController extends Controller{

    function index() {
        //dd(new PostResource(Post::all()));
        return Inertia::render('Index/postindex',[
        "posts" => Post::with('user:id,name')->paginate(15),
        'users' => User::all(),
        ] );
    }
    function delete($id){
        $post = Post::find($id);
        $post->delete();
        return back()->with("success","");
    }

    function update($id,Request $request){
        $validated = $request->validate([
            "title"=> ["required","min:3",Rule::unique('posts')->ignore($request->id)],
            "description"=> ["required","min:10"],
            "user_id"=> ["required","exists:App\Models\User,id"],
            ]);
        $post = Post::find($id);
        //dd($request, $post);
        $post->title=$validated["title"];
        $post->description=$validated["description"];
        $post->user_id=$validated["user_id"];
        $post->save();
        return back()->with("success","");
    }

    function create(Request $request){
        // dd($request);
        $validated = $request->validate([
            "title"=> ["required","min:3","unique:App\Models\Post,title"],
            "description"=> ["required","min:10"],
            "user_id"=> ["required","exists:App\Models\User,id"],
            ]);
        $post = new Post([
            "title"=> $request["title"],
            "description"=> $request["description"],
            "user_id"=> $request["user_id"],
        ]);
        $post->save();
        return back()->with("success","");
    }
}
