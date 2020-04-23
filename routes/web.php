<?php

use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
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

$posts = collect();
foreach ($files as $key => $value) {
    $view = view('posts.' . Str::replaceLast('.blade', '', $value->getFilenameWithoutExtension()));
    $data = $view->renderSections();
    $post = new stdClass();
    $post->title = $data['title'] ?? '';
    $post->excerpt = $data['excerpt'] ?? '';
    $post->date = $data['date'] ?? '';
    $posts->add($post);
}


Route::get('/', function () use ($posts){
    return view('welcome')->with(compact('posts'));
});