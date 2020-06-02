<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Markdown\MarkdownPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithFaker;

class SearchMarkdownPostTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        MarkdownPost::fake();
    }

    /** @test */
    public function searching_posts_is_possible()
    {
        $foundPosts = MarkdownPost::search('Post number one');

        $this->assertNotNull($foundPosts);
        $this->assertNotCount(0, $foundPosts);
    }

    /** @test */
    public function the_searched_post_is_found()
    {
        $post = new MarkdownPost('post-number-one.md');
        $foundPosts = MarkdownPost::search('Post number one');

        $this->assertNotNull($foundPosts);
        $this->assertSame($foundPosts->first()->title, $post->title);
    }
}
