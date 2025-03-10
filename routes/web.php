<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostsController::class, 'index'])->name("posts.index");
Route::get('/posts/create', [PostsController::class, 'create'])->name("posts.create");
Route::get('/posts/{id}/edit/', [PostsController::class, 'edit'])->name("posts.edit");
Route::put("/posts", [PostsController::class, "update"])->name("posts.update");
Route::get('/posts/{id}', [PostsController::class, 'show'])->name("posts.show");
Route::post("/posts", [PostsController::class, "store"])->name("posts.store");
Route::delete("/posts/{id}", [PostsController::class, "destroy"])->name("posts.destroy");
Route::post("/comments", [CommentController::class, "store"])->name("comments.store");
Route::get('/posts/{id}/restore/', [PostsController::class, 'restore'])->name("posts.restore");
