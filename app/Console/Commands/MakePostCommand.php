<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MakePostCommand extends GeneratorCommand
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:post 
    {name : The name of the post, for example "This is my cool new Post"}
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

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app_path('Stubs/Post.stub');
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::slug($this->argument('name'));

        return config('posts.location')."/{$name}.blade.php";
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [
            '{{ title }}' => $this->argument('name'),

            '{{ date }}' => '',

            '{{ slugs }}' => '[]',

            '{{ tags }}' => '[]',

            '{{ excerpt }}' => '',

            '{{ header-image }}' => 'https://placehold.it/1024x768',

            '{{ list-header-image }}' => 'https://placehold.it/600x300',
            
            '{{ content }}' => '',
        ];

        $stub = $this->files->get($this->getStub());

        return str_replace(
            array_keys($replace), array_values($replace), $stub
        );
    }

}
