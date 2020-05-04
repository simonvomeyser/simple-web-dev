<?php

use App\Post;
use Illuminate\Support\Facades\Route;

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
    $posts = Post::released();

    return view('index')->with('posts', $posts->only(0, 1, 2));
})->name('index');

Route::get('/posts', function () {
    return view('posts')->with('posts', Post::released());
})->name('posts');

Route::get('/{slug}', function ($slug) {
    $post = Post::findBySlug($slug);

    return $post ?? abort(404);
})->name('posts.single');

Route::get('/about', function () {
    return 'todo';
})->name('about');
