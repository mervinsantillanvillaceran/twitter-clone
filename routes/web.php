<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\CommentController;

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
    // Follow and unfollow users
    Route::post('/follow/{id}', [FollowerController::class, 'store'])->name('followers.store');
    Route::post('/unfollow/{id}', [FollowerController::class, 'destroy'])->name('followers.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::resource('tweets', TweetController::class);

    Route::post('/comments/{id}', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
