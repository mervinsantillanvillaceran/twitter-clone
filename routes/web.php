<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth']], function () {
    // users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/following', [UserController::class, 'following'])->name('users.following');
    Route::get('/users/{id}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::get('/users/{id}/tweets', [UserController::class, 'tweets'])->name('users.tweets');

    // Follow and unfollow users
    Route::post('/follow/{id}', [FollowerController::class, 'store'])->name('followers.store');
    Route::post('/unfollow/{id}', [FollowerController::class, 'destroy'])->name('followers.destroy');

    // tweets
    Route::resource('tweets', TweetController::class);

    // comments
    Route::post('/comments/{id}', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // message
    Route::get('/messages/{id}', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{id}', [MessageController::class, 'store'])->name('messages.store');
});

require __DIR__.'/auth.php';
