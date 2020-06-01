<?php

namespace App\Console\Commands;

use App\Markdown\MarkdownPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CachePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches markdown posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Cache::forget('markdownPosts');
        Cache::forever('markdownPosts', MarkdownPost::all());
    }
}
