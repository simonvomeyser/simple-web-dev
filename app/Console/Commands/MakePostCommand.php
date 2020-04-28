<?php

namespace App\Console\Commands;

use App\Post;
use Illuminate\Console\Command;

class MakePostCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:post 
    {title : The name of the post, for example "This is my cool new Post"}
    ';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Post';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Blade Post';

    public function handle()
    {
        factory(Post::class)->create(['title' => $this->argument('title')]);
    }
}
