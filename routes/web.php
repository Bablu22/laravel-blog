<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\FollowController;

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
    if (auth()->check()) {
        return view('home-page', ['posts' => auth()->user()->feedPosts()->latest()->paginate(10)]);
    } else {
        return view('welcome');
    }

});

Route::get('/admin-only', function () {
    return 'Only admins able to access this';
})->middleware('can:visitAdminPage');

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout')->middleware('mustBeLogIn');

    // Profile related route
    Route::get('/profile/{user:username}', 'profile')->name('profile');
    Route::get('/manager-avatar', 'ShowAvatarForm')->name('profile.avatar')->middleware('mustBeLogIn');
    Route::post('/avatar-store', 'StoreAvatar')->name('avatar.store')->middleware('mustBeLogIn');

    // User flowers related route
    Route::get('/profile/{user:username}/followers', 'profileFollowers')->name('profile.followers');
    Route::get('/profile/{user:username}/following', 'profileFollowing')->name('profile.following');

});


// Post controller
Route::controller(PostController::class)->group(function () {
    Route::get('/post/create', 'create')->name('post.create')->middleware('mustBeLogIn');
    Route::post('/post/store', 'store')->name('post.store')->middleware('mustBeLogIn');
    Route::get('/post/{post}', 'show')->name('post.show');
    Route::delete('/post/{post}', 'destroy')->name('post.delete')->middleware('can:delete,post');
    Route::get('/post/{post}/edit', 'edit')->name('post.edit')->middleware('can:update,post');
    Route::put('/post/{post}/update', 'update')->name('post.update')->middleware('can:update,post');

    // Search
    Route::get('/post/search/{term}', 'search')->name('post.search');
});


// Follow controller
Route::controller(FollowController::class)->group(function () {
    Route::post('/create-/follow/{user:username}', 'createFollow')->name('follow.create');
    Route::post('/remove-/follow/{user:username}', 'removeFollow')->name('follow.remove');
});


