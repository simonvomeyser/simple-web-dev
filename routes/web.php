<?php

use App\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
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
    $posts = Post::all();
    return view('index')->with("posts", $posts);
})->name('index');

Route::get('posts/{slug}', function ($slug) {

    // Later: Posts::findOrFail($slug)

    return view("posts.$slug");
})->name('posts.single');
