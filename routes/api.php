<?php

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {

    return UserResource::collection(User::all());
});

Route::get('/user/{id}', function (string $id) {
    return new UserResource(User::findOrFail($id));
});

Route::get('/posts', function (Request $request) {

    return PostResource::collection(Post::all());
});

Route::get('/post/{id}', function (string $id) {
    return new PostResource(Post::findOrFail($id));
});
