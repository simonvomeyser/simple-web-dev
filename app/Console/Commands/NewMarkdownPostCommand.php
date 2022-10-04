<?php

namespace App\Console\Commands;

use App\Markdown\MarkdownPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewMarkdownPostCommand extends Command
{
    protected $signature = 'make:markdown-post {title}';

    protected $description = 'Creates a new markdown post';

    public function handle()
    {
        $tags = MarkdownPost::all()->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $selectedTags = $this->choice(
            'What tags to add, (separate by comma)?',
            $tags,
            multiple: true
        );

        $title = str($this->argument('title'))->replace('title=', ' ');
        $content = File::get($this->getStub());
        $slug = Str::slug($title);
        $destination = base_path("resources/markdown/{$slug}.md");

        if (File::exists($destination)) {
            $this->error('Post ' . $destination . ' already exists');
            return 1;
        }

        $content = Str::replace('{{title}}', $title, $content);
        $content = Str::replace('{{slug}}', $slug, $content);

        foreach ($selectedTags as $tag) {
            $content = Str::replace("{{tags}}", "  - $tag " . PHP_EOL . "{{tags}}", $content);
        }
        $content = Str::replace('{{tags}}', "", $content);

        File::put($destination, $content);

        $this->line('Post ' . $destination . ' created. Happy writing!');
        return 0;
    }

    protected function getStub()
    {
        return app_path('Stubs/MarkdownPost.stub');
    }

    private function getDestinationPath(string $slug)
    {
    }
}
