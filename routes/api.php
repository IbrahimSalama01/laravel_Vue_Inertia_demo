<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->get('/users', [UserController::class,"index"]);

Route::middleware("auth:sanctum")->get('/users/{id}', [UserController::class,"show"]);

Route::middleware("auth:sanctum")->get('/posts', [PostController::class,"index"]);

Route::middleware("auth:sanctum")->get('/posts/{id}', [PostController::class,"show"]);

Route::middleware("auth:sanctum")->post('/posts', [PostController::class,"store"]);

Route::post('/sanctum/token',[UserController::class,"createToken"] );
