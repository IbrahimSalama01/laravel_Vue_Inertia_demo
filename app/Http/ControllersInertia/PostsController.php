<?php
namespace App\Http\ControllersInertia;

use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\PostLimitThree;
use Illuminate\Support\Facades\Storage;

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
        $extensions = ['jpg', 'jpeg', 'png','jfif'];
        foreach($extensions as $ext){
            Storage::delete("photos/".$id.".". $ext);
        }
        return back()->with("success","");
    }

    function update($id,Request $request){
      //  dd($request);
        $extensions = ['jpg', 'jpeg', 'png','jfif'];

        $validated = $request->validate([
            "title"=> ["required","min:3",Rule::unique('posts')->ignore($request->id)],
            "description"=> ["required","min:10"],
            "user_id"=> ["required","exists:App\Models\User,id"],
            'photo' => ["file","image","mimetypes:image/jpeg,image/png","max:2048"],
            ]);
        $post = Post::find($id);
        //dd($request, $post);
        //dd($request->all(), $request->file('photo')->getMimeType());

        $post->title=$validated["title"];
        $post->description=$validated["description"];
        $post->user_id=$validated["user_id"];
        $post->save();
        $file = $request->file("photo");
        if($file != null){
            foreach($extensions as $ext){
                Storage::delete("photos/".$id.".". $ext);
            }
            Storage::put("photos/".$post->id.".".$file->getClientOriginalExtension(), file_get_contents($file));
        }
        return back()->with("success","");
    }

    function store(Request $request){
        //dd($request);
        $validated = $request->validate([
            "title"=> ["required","min:3","unique:App\Models\Post,title"],
            "description"=> ["required","min:10"],
            "user_id"=> ["required","exists:App\Models\User,id",new PostLimitThree],
            'photo' => ["required","file","image","mimes:jpg,png","max:2048"]
            ]);

        $post = new Post([
            "title"=> $request["title"],
            "description"=> $request["description"],
            "user_id"=> $request["user_id"],
        ]);
        $post->save();
        $file = $request->file("photo");
        Storage::put("photos/".$post->id.".".$file->getClientOriginalExtension(), file_get_contents($file));
        return back()->with("success","");
    }
}
