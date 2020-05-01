<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Tests\TestCase;

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
        $this->get(route('posts'))->assertSee(__('posts.no-posts-found'));
    }

    /** @test */
    public function posts_are_found_with_essential_data()
    {
        $posts = factory('App\Post', 6)->create();

        $response = $this->get(route('posts'));

        foreach ($posts as $post) {
            $response
                ->assertSee($post->title)
                ->assertSee($post->link())
                ->assertSee($post->excerpt)
                ->assertSee($post->list_header_image);
        }
    }

    /** @test */
    public function only_released_posts_are_shown()
    {
        $postWithoutReleaseDate = factory('App\Post')->create(['release_date' => '']);
        $postWithFutureReleaseDate = factory('App\Post')->create(['release_date' => Carbon::tomorrow()]);
        $postWithReleaseDate = factory('App\Post')->create();

        $this->get(route('posts'))
            ->assertSee($postWithReleaseDate->link())
            ->assertDontSee($postWithoutReleaseDate->link())
            ->assertDontSee($postWithFutureReleaseDate->link());
    }
}
