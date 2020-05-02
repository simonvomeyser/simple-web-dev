<?php

namespace App;

use App\BladeBasedModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Post extends BladeBasedModel
{
    public function getFilename(): string
    {
        return Str::slug($this->title);
    }

    public function link(): string
    {
        return $this->slug();
    }

    public function slug(): string
    {
        return Str::slug($this->title);
    }

    public static function released()
    {
        return static::all()->filter(function ($post) {
            // todo: find better way to do this
            if (config('app.env') === 'local') {
                return true;
            }

            if (!$post->release_date) {
                return false;
            }

            return Carbon::parse($post->release_date)->isBefore(Carbon::now());
        })->sortByDate('release_date');
    }

    public static function findBySlug($slug)
    {
        return static::all()->filter(function ($post) use ($slug) {
            return $post->slug() === $slug;
        })->first();
    }
}
