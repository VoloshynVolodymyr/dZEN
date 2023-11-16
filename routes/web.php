<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')
    ->group(function () {

        Route::get('/', [IndexController::class, 'index'])->name('home');
        Route::get('/about', [IndexController::class, 'about'])->name('about');

        Route::resource('users', UserController::class);
        Route::resource('comments', CommentController::class);

        Route::get('/comments/create/{parent_id?}', [CommentController::class, 'create'])->name('comments.create');

    });

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->name('login')->middleware('guest');
        Route::delete('/logout', 'logout')->name('logout')->middleware('auth');
    });


Route::inertia('/login', 'Login');
