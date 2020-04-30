<?php

namespace App;

use App\BladeBasedModel;
use Carbon\Carbon;
use Illuminate\Support\Str;


class Post extends BladeBasedModel
{
    function getFilename(): string
    {
        return Str::slug($this->title);
    }

    function link(): string
    {
        return route('posts.single', Str::slug($this->title));
    }

    public static function released()
    {
        return static::all()->filter(function ($post) {

            if (!$post->release_date) {
                return false;
            }

            return Carbon::parse($post->release_date)->isBefore(Carbon::now());
        });
    }
}
