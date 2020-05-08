<?php

namespace Tests\Feature;

use App\Markdown\MarkdownPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
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

        $posts = MarkdownPost::released()->forPage(1, 3)->toArray();

        $response->assertSeeInOrder([$posts[0]->title, $posts[1]->title, $posts[2]->title]);

        // Inner order of properties
        foreach ($posts as $post) {
            $response->assertSeeInOrder([$post->list_image, $post->title, $post->excerpt]);
        }
    }

    /** @test */
    public function only_three_posts_are_passed_to_the_view()
    {
        MarkdownPost::fake();

        $this->get('/')->assertViewHas('posts', function ($posts) {
            return $posts->count() < 4;
        });
    }

    public function only_released_posts_are_shown()
    {
        MarkdownPost::fake();

        $this->get('/')->assertViewHas('posts', function ($posts) {
            return $posts->isReleased();
        });
    }
}
