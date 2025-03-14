<?php
use App\Http\Controllers\ProfileController;
use App\Http\ControllersInertia\PostsController;
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

Route::get('/posts', [PostsController::class,'index'])->name('posts.index');
Route::delete("/post/{id}",[PostsController::class,"delete"])->name("posts.destroy");

Route::put("/post/{id}",[PostsController::class,"update"])->name("posts.update");



Route::post("/posts", [PostsController::class,"create"])->name("posts.create");






Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
