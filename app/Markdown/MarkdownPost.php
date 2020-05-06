<?php

namespace App\Markdown;

use Illuminate\Support\Str;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class MarkdownPost
{
    public $title;
    public $content;
    public $excerpt;
    public $release_date;
    public $slug;
    public $tags;
    public $header_image;
    public $list_image;

    public function __construct($file)
    {
        $fileContents = File::get(static::getFolderPath() . $file);
        $yamlObject = YamlFrontMatter::parse($fileContents);

        $this->mapToProperties($yamlObject->matter());
        $this->parseContent($yamlObject->body());
    }

    public function getLink()
    {
        return route('posts.single', ['slug' => $this->getSlug()]);
    }

    public function getSlug()
    {
        return $this->slug ?? Str::slug($this->title);
    }

    protected function mapToProperties(array $frontMatterData)
    {
        foreach ($frontMatterData as $key => $value) {
            $this->$key = $value;
        }

        if ($this->release_date) {
            $this->release_date = Carbon::parse($this->release_date);
        }

        if (!$this->tags) {
            $this->tags = [];
        }
    }
    public function isReleased()
    {
        return $this->release_date && $this->release_date->isPast();
    }

    protected function parseContent(string $markdown)
    {
        $this->content = Markdown::parse($markdown);
    }

    public static function all()
    {
        $collection = collect();

        if (!File::isDirectory(static::getFolderPath())) {
            return $collection;
        }

        $files = File::allFiles(static::getFolderPath());

        foreach ($files as $file) {
            $collection->add(new self($file->getFilename()));
        }

        return $collection->sortByDate('release_date');
    }

    public static function released()
    {
        return static::all()->filter(function ($post) {
            return $post->isReleased();
        });
    }

    public static function find($slug)
    {
        return static::all()->filter(function ($post) use ($slug) {
            return $post->slug === $slug;
        })->first();;
    }

    public static function getFolderPath(): string
    {
        if (env('APP_ENV') === 'testing') {
            return base_path('tests/Fixtures/');
        }

        return resource_path('markdown/');
    }
}
