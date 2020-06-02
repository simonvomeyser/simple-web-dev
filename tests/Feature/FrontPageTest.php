<?php

namespace Tests\Feature;

use App\Markdown\MarkdownPost;
use Tests\TestCase;

class FrontPageTest extends TestCase
{
    /** @test */
    public function the_frontpage_is_reachable()
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    /** @test */
    public function the_page_shows_no_post_if_none_are_present()
    {
        MarkdownPost::fake('empty/folder');
        $this->get('/')->assertSee(trans('posts.no-posts-found'));
    }

    /** @test */
    public function released_posts_and_their_preview_are_shown_in_right_order()
    {
        MarkdownPost::fake();

        $response = $this->get('/');

        $posts = MarkdownPost::released();

        $response->assertSeeInOrder([$posts[0]->title, $posts[1]->title, $posts[2]->title]);

        // Inner order of properties
        foreach ($posts as $post) {
            $response->assertSeeInOrder([$post->list_image, $post->title, $post->excerpt]);
        }
    }
    /** @test */
    public function posts_are_found_with_essential_data()
    {
        MarkdownPost::fake();
        $posts = MarkdownPost::released();

        $response = $this->get('/');

        foreach ($posts as $post) {
            $response
                ->assertSee($post->title)
                ->assertSee($post->getLink())
                ->assertSee($post->excerpt)
                ->assertSee($post->list_image);
        }
    }
    /** @test */
    public function only_released_posts_are_shown()
    {
        MarkdownPost::fake();

        $unreleasedPosts = MarkdownPost::all()->filter(function (MarkdownPost $post) {
            return !$post->isReleased();
        });

        $response = $this->get('/');

        foreach ($unreleasedPosts as $post) {
            $response
                ->assertDontSee($post->title)
                ->assertDontSee($post->getLink());
        }
    }
}
