<?php

namespace App\Markdown;

use Illuminate\Mail\Markdown;
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

    public function mapToProperties(array $frontMatterData)
    {
        foreach ($frontMatterData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function parseContent(string $markdown)
    {
        $this->content = Markdown::parse($markdown);
    }



    public static function getFolderPath(): string
    {
        if (env('APP_ENV') === 'testing') {
            return base_path('tests/Fixtures/');
        }

        return resource_path('markdown/');
    }
}
