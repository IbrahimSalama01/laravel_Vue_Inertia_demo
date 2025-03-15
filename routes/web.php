<?php
use App\Http\ControllersInertia\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostsControllerPHP;
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

Route::middleware("auth")->get('/posts', [PostsController::class,'index'])->name('posts.index');
Route::middleware("auth")->delete("/posts/{id}",[PostsController::class,"delete"])->name("posts.destroy");
Route::middleware("auth")->put("/posts/{id}",[PostsController::class,"update"])->name("posts.update");
Route::middleware("auth")->post ("/posts/{id}",[PostsController::class,"update"])->name("posts.update");

Route::middleware("auth")->post("/posts", [PostsController::class,"store"])->name("posts.create");



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Route::get('/post/{id}', [PostsControllerPHP::class,'show'])->name('posts.show');
Route::post("/comments", [CommentController::class, "store"])->name("comments.store");
Route::get('/posts/{slug}', [PostsControllerPHP::class,'showslug'])->name('posts.show');
Route::get('/photos/{filename}', [PhotoController::class, 'show']);
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
// Route::get('/posts', [PostsController::class, 'index'])->name("posts.index");
// Route::get('/posts/create', [PostsController::class, 'create'])->name("posts.create");
// Route::get('/posts/{id}/edit/', [PostsController::class, 'edit'])->name("posts.edit");
// Route::put("/posts", [PostsController::class, "update"])->name("posts.update");
// Route::get('/posts/{id}', [PostsController::class, 'show'])->name("posts.show");
// Route::post("/posts", [PostsController::class, "store"])->name("posts.store");
// Route::delete("/posts/{id}", [PostsController::class, "destroy"])->name("posts.destroy");
// Route::get('/posts/{id}/restore/', [PostsController::class, 'restore'])->name("posts.restore");

