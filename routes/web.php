<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'ideas', 'as' => 'ideas.'], function () {
    Route::get('/{idea}', [IdeaController::class, 'show'])->name('show');

    Route::group(['middleware' => ['auth']], function () {
        Route::post('/', [IdeaController::class, 'store'])->name('store');
        Route::get('/{idea}/edit', [IdeaController::class, 'edit'])->name('edit');
        Route::put('/{idea}', [IdeaController::class, 'update'])->name('update');
        Route::delete('/{idea}', [IdeaController::class, 'destroy'])->name('destroy');

        Route::post('/{idea}/comments', [CommentController::class, 'store'])->name('commentstore');

        Route::post('/{idea}/like', [IdeaLikeController::class, 'like'])->name('like');
        Route::post('/{idea}/unlike', [IdeaLikeController::class, 'unlike'])->name('unlike');
    });
});

Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['auth']], function () {
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');

    Route::post('/{user}/follow', [FollowerController::class, 'follow'])->name('follow');
    Route::post('/{user}/unfollow', [FollowerController::class, 'unfollow'])->name('unfollow');
});

Route::get('/profile', [UserController::class, 'profile'])
    ->middleware('auth')
    ->name('profile');

Route::get('/terms', [DashboardController::class, 'terms'])->name('terms');

// using invokable controller 1 function only
Route::get('/feed', FeedController::class)
    ->middleware('auth')
    ->name('feed');

// ADMIN
Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'can:admin'])
    ->name('admin.dashboard');
