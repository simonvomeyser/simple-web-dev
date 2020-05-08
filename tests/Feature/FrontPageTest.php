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
        factory('App\Post', 5)->create();

        $this->get('/')->assertViewHas('posts', function ($posts) {
            return $posts->count() < 4;
        });
    }

    /** @test */
    public function only_released_posts_are_not_shown()
    {
        $postWithoutReleaseDate = factory('App\Post')->create(['release_date' => '']);
        $postWithFutureReleaseDate = factory('App\Post')->create(['release_date' => Carbon::tomorrow()]);
        $postWithReleaseDate = factory('App\Post')->create();

        $this->get('/')
            ->assertSee($postWithReleaseDate->link())
            ->assertDontSee($postWithoutReleaseDate->link())
            ->assertDontSee($postWithFutureReleaseDate->link());
    }


    /** @test */
    public function the_three_latest_posts_are_found()
    {
        factory('App\Post', 3)->create(['release_date' => Carbon::now()->subMonth()]);
        $currentPosts = factory('App\Post', 3)->create(['release_date' => Carbon::yesterday()]);
        factory('App\Post', 3)->create(['release_date' => Carbon::now()->subYear()]);

        $response = $this->get('/');

        foreach ($currentPosts as $post) {
            $response
                ->assertSee($post->title)
                ->assertSee($post->excerpt)
                ->assertSee($post->list_header_image);
        }
    }
}
