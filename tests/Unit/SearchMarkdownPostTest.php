<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Markdown\MarkdownPost;

class SearchMarkdownPostTest extends TestCase
{
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

    /** @test */
    public function only_the_searched_post_is_found()
    {
        $this->assertCount(1, MarkdownPost::search('Post number one'));
    }

    /** @test */
    public function searched_tags_are_found()
    {
        $post = new MarkdownPost('post-number-one.md');
        $foundPosts = MarkdownPost::search('Post NUMBER one Tag');

        $this->assertNotNull($foundPosts);
        $this->assertSame($foundPosts->first()->title, $post->title);
    }

    /** @test */
    public function searched_excerpt_parts_are_found()
    {
        $post = new MarkdownPost('post-number-one.md');
        $foundPosts = MarkdownPost::search('A searchable part of the excerpt.');

        $this->assertNotNull($foundPosts);
        $this->assertSame($foundPosts->first()->title, $post->title);
    }
}
