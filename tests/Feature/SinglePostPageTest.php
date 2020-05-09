<?php

namespace Tests\Feature;

use App\Markdown\MarkdownPost;
use Tests\TestCase;

class SinglePostPageTest extends TestCase
{
    /** @test */
    public function all_posts_are_reachable_via_their_link()
    {
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
}
