<?php

use App\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\View;

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
    return view('index')->with('posts', Post::released());
})->name('posts');

Route::get('/{slug}', function ($slug) {
    $post = Post::findBySlug($slug);

    return $post ?? abort(404);
})->name('posts.single');
