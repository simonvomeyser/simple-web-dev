<?php

namespace Tests\Feature;

use App\Markdown\MarkdownPost;
use Tests\TestCase;

class SinglePostPageTest extends TestCase
{
    /** @test */
    public function all_posts_are_reachable_via_their_link()
    {
        $this->withoutExceptionHandling();
        MarkdownPost::fake();
        $posts = MarkdownPost::all();

        foreach ($posts as $post) {
            $this->get($post->getLink())
                ->assertOk();
        }
    }

    /** @test */
    public function all_posts_contain_their_content_on_their_page()
    {
        MarkdownPost::fake();
        $posts = MarkdownPost::all();

        foreach ($posts as $post) {
            $this->get($post->getLink())
                ->assertSee($post->title)
                ->assertSee($post->content)
                ->assertSee($post->header_image);
        }
    }

    /** @test */
    public function it_contains_at_least_the_first_simlar_post()
    {
        MarkdownPost::fake();
        $post = MarkdownPost::all()->first();

        $firstSimilarPost = $post->similar()->first();
        
        $this->get($post->getLink())
            ->assertSee($firstSimilarPost->title)
            ->assertSee($firstSimilarPost->excerpt)
            ->assertSee($firstSimilarPost->getLink());
    }
}
