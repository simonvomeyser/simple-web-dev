<?php

namespace App\Markdown;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use InvalidArgumentException;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\MarkdownConverter;
use SimonVomEyser\CommonMarkExtension\LazyImageExtension;
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

    public static $folderPath;

    public function __construct($file)
    {
        $fileContents = File::get(static::getFolderPath() . $file);
        $yamlObject = YamlFrontMatter::parse($fileContents);

        $this->content = $this->parseMarkdownToHTML($yamlObject->body());
        $this->mapToProperties($yamlObject->matter());
    }


    public function getLink()
    {
        return route('posts.single', ['slug' => $this->getSlug()]);
    }

    public function readingTime()
    {
        $word = str_word_count(strip_tags($this->content));
        $minutes = intval(floor($word / 200));
        return $minutes > 0 ? $minutes : 1;
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

        if ($this->excerpt) {
            // Needed since YAML Lib seems to parse double newline as one
            // This needs to happen so Markdown with more "p" tags can be created
            $doubleNewlineExcerpt = preg_replace('/([\n\r])/', '$1$1', $this->excerpt);
            $this->excerpt = $this->parseMarkdownToHTML($doubleNewlineExcerpt);
        } else {
            $this->excerpt = '';
        }
    }

    public function isReleased()
    {
        return $this->release_date && $this->release_date->isPast();
    }

    public function getReadableRelease()
    {
        $date = $this->release_date;

        if (!$date) {
            return "Draft";
        }

        return ($date->isFuture() ? 'Planned for ' : '') . $date->diffForHumans();
    }

    protected function parseMarkdownToHTML(string $markdown)
    {
        $environment = new Environment([
            'lazy_image' => [
                'strip_src' => true,
                'html_class' => 'lozad',
                'data_attribute' => 'src',
            ],
            'allow_unsafe_links' => false,
            'external_link' => [
                'internal_hosts' => config('app.url'),
                'open_in_new_window' => true,
                'html_class' => 'external-link',
            ],
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new LazyImageExtension());

        $converter = new MarkdownConverter($environment);

        return new HtmlString($converter->convert($markdown));
    }

    /**
     * @return Collection
     * @throws InvalidArgumentException
     * @todo Find a better implemention, this only filters out current
     */
    public function similar()
    {
        return static::released()->filter(function ($post) {
            return $post->slug !== $this->slug;
        });
    }

    public function contains($word)
    {
        $lowerCaseWord = Str::lower($word);

        $tagsContainWord = !!Arr::where($this->tags, function ($tag) use ($lowerCaseWord) {
            return Str::contains(Str::lower($tag), $lowerCaseWord);
        });

        return $tagsContainWord ||
            Str::contains(Str::lower($this->title), $lowerCaseWord) ||
            Str::contains(Str::lower($this->excerpt), $lowerCaseWord);
    }

    public static function all()
    {
        if (app()->environment() !== 'local' && Cache::has('markdownPosts')) {
            return Cache::get('markdownPosts');
        }

        $collection = collect();

        if (!File::isDirectory(static::getFolderPath())) {
            return $collection;
        }

        $files = File::allFiles(static::getFolderPath());

        foreach ($files as $file) {
            $collection->add(new self($file->getFilename()));
        }

        return $collection->sortByDate('release_date')->values();
    }

    public static function search($searchString)
    {
        return static::released()->filter(function ($post) use ($searchString) {
            return $post->contains($searchString);
        })->values();
    }


    public static function released()
    {
        return static::all()->filter(function ($post) {
            return $post->isReleased();
        })->values();
    }

    public static function find($slug)
    {
        return static::all()->filter(function ($post) use ($slug) {
            return $post->slug === $slug;
        })->first();
    }

    public static function getFolderPath(): string
    {
        return static::$folderPath ?? resource_path('markdown/');
    }

    public static function fake($folderPath = null)
    {
        static::$folderPath = $folderPath ?? base_path('tests/Fixtures/');
    }

    public static function unfake()
    {
        static::$folderPath = null;
    }
}
