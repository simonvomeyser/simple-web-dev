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
}
