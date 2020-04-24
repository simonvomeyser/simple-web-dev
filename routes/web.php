<?php

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
$files = File::allFiles(resource_path('views/posts'));

// dd(app(FileViewFinder::class, ['paths' => [resource_path('views').'/posts']]));
$posts = new Collection();
foreach ($files as $key => $value) {
    $viewName = Str::before($value->getFilenameWithoutExtension(), '.blade');
    $view = view("posts.$viewName");
    $data = $view->renderSections();
    $post = new stdClass();
    $post->title = $data['title'] ?? '';
    $post->slug = $viewName;
    $post->excerpt = $data['excerpt'] ?? '';
    $post->date = $data['date'] ?? '';
    $posts->add($post);
}


Route::get('/', function () use ($posts){
    return view('welcome')->with("posts" , $posts->only(0,1));
})->name('index');

Route::get('posts/{slug}', function($slug) {

    // Later: Posts::findOrFail($slug)

    return view("posts.$slug");
})->name('posts.single');