<?php

namespace App;

use App\BladeBasedModel;
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
}
