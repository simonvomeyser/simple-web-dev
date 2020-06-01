<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Markdown\MarkdownPost;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class MarkdownPostCacheTest extends TestCase
{
    /** @test */
    public function it_does_not_save_the_posts_to_the_cache_normally()
    {
        $this->assertNull(Cache::get('markdownPosts'));

        MarkdownPost::all();

        $this->assertNull(Cache::get('markdownPosts'));
    }

    /** @test */
    public function the_command_to_cache_the_posts_exists()
    {
        $posts = MarkdownPost::all();
        
        Artisan::call('cache-posts');

        $cachedPosts = Cache::get('markdownPosts');

        $this->assertNotNull($cachedPosts);
        $this->assertCount($cachedPosts->count(), $posts);
    }

    /** @test */
    public function after_the_command_the_cached_posts_are_returned()
    {

        Cache::put('markdownPosts', collect(['test']));

        $fakePosts = MarkdownPost::all();

        $this->assertTrue($fakePosts->first() === 'test');
    }
}
