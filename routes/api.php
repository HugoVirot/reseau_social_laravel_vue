<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;


// ****************** Inscription et connexion ****************

// inscription
Route::post('register', [UserController::class, 'store'])->name('register');

// connexion
Route::post('login', [LoginController::class, 'login'])->name('login');

// déconnexion
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:web');


// ****************** Routes ApiResource ****************

// route ressource users
Route::apiResource("users", UserController::class);

// route ressource posts
Route::apiResource("posts", PostController::class);

// route ressource comments
Route::apiResource("comments", CommentController::class);


// ****************** Autres ****************

// récupérer l'utilisateur connecté (nouvelle route Sanctum dans Laravel 11)
Route::get('/user', function (Request $request) {
    return $request->user();
});
//->middleware('auth:sanctum');

// réponse personnalisée renvoyée en cas de demande d'une route non-existante (ereur 404)
Route::fallback(function () {
    return response()->json([
        'message' => 'La route que vous demandez n’existe pas'
    ], 404);
});
