<?php

use App\Http\Controllers\ProfileController;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/posts', function () {
    //dd(new PostResource(Post::all()));
return Inertia::render('Index/postindex',[
    "posts" => Post::with('user:id,name')->paginate(15),
    'users' => User::all(),
    ] );
});
Route::delete("/post/{id}",function($id){
    $post = Post::find($id);
    $post->delete();
    return back()->with("success","");
});

Route::put("/post/{id}",function($id,Request $request){
    $post = Post::find($id);
    //dd($request, $post);
    $post->title=$request["title"];
    $post->description=$request["description"];
    $post->user_id=$request["user_id"];
    $post->save();
    return back()->with("success","");
});



Route::post("/posts",function(Request $request){
    $post = new Post([
        "title"=> $request["title"],
        "description"=> $request["description"],
        "user_id"=> $request["user_id"],
    ]);
    $post->save();
    return back()->with("success","");
});






Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
