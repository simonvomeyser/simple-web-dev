<?php

use App\Markdown\MarkdownPost;
use Illuminate\Http\Request;
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

Route::get('/test', function() {
  return \Illuminate\Mail\Markdown::parse('# Hello');
});
Route::view('legal-notice', 'legal-notice')->name('legal-notice');
Route::view('privacy', 'privacy')->name('privacy');

Route::get('/', function (Request $request) {

    $searchString = $request->input('q');

    if ($searchString) {
        $posts = MarkdownPost::search($searchString);
        return view('index')->with(compact('posts', 'searchString'));
    }

    return view('index')->with('posts', MarkdownPost::released());
})->name('index');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/{slug}', function ($slug) {
    $post = MarkdownPost::find($slug);

    return $post ? view('post')->with(compact('post')) : abort(404);
})->name('posts.single');
