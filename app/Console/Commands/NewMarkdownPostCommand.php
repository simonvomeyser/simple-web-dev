<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewMarkdownPostCommand extends Command
{
    protected $signature = 'make:markdown-post {title}';

    protected $description = 'Creates a new markdown post';

    public function handle()
    {
        $content = File::get($this->getStub());
        $slug = Str::slug($this->argument('title'));
        $destination = base_path("resources/markdown/{$slug}.md");

        if(File::exists($destination)) {
            $this->error('Post '.$destination.' already exists');
            return;
        }

        $content = Str::replace('{{title}}', $this->argument('title'), $content);
        $content = Str::replace('{{slug}}', $slug, $content);

        File::put(resource_path($destination), $content);
    }

    protected function getStub()
    {
        return app_path('Stubs/MarkdownPost.stub');
    }

    private function getDestinationPath(string $slug)
    {
    }
}
