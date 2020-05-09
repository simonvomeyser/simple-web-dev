<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Markdown\MarkdownPost;
use Illuminate\Support\Carbon;

class PostsPageTest extends TestCase
{
    /** @test */
    public function the_page_is_reachable()
    {
        $response = $this->get(route('posts'));

        $response->assertOk();
    }

    /** @test */
    public function the_page_shows_no_post_if_none_are_present()
    {
        MarkdownPost::fake('empty/folder');

        $this->get(route('posts'))->assertSee(trans('posts.no-posts-found'));
    }

    /** @test */
    public function posts_are_found_with_essential_data()
    {
        MarkdownPost::fake();
        $posts = MarkdownPost::released();

        $response = $this->get(route('posts'));

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

        $response = $this->get(route('posts'));

        foreach ($unreleasedPosts as $post) {
            $response
                ->assertDontSee($post->title)
                ->assertDontSee($post->getLink());
        }
    }

    /** @test */
    public function released_posts_are_shown_in_right_order()
    {
        MarkdownPost::fake();

        $posts = MarkdownPost::released();

        $this->get(route('posts'))
            ->assertSeeInOrder([$posts[0]->title, $posts[1]->title, $posts[2]->title]);
    }
}
