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
        return $this->slug();
    }

    public function link(): string
    {
        return $this->slug();
    }

    public function slug(): string
    {
        return !!$this->slug ? $this->slug : Str::slug($this->title);
    }

    // todo: this should be "casts"
    public function tags(): array
    {
        return json_decode(html_entity_decode($this->tags)) ?? [];
    }

    public function readingTime(): string
    {
        $word = str_word_count(strip_tags($this->content));
        $minutes = floor($word / 200);
        return $minutes;
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
