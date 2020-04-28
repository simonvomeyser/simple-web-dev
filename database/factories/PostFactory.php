<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Date;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {
    $tags = ['Productivity', 'Dev Ops', 'Frontent', 'Backend'];
    shuffle($tags);

    return [
        'title' => $faker->title,
        'release_date' => Date::now(),
        'slugs' => [],
        'excerpt' => $faker->text(25),
        'tags' => array_slice($tags, random_int(0, count($tags))),
        'header_image' => 'https://placehold.it/1024x768',
        'list_header_image' => 'https://placehold.it/1024x768',
        'content' => $faker->paragraphs(),
    ];
});
