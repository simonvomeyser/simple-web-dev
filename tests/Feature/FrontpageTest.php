<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FrontpageTestt extends TestCase
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
        $this->get('/')->assertSee(__('posts.no-posts-found'));
    }

    /** @test */
    public function three_created_posts_are_found_with_essential_data()
    {
        $posts = factory('App\Post', 3)->create();

        $response = $this->get('/');

        foreach ($posts as $post) {
            $response
                ->assertSee($post->title)
                ->assertSee($post->excerpt)
                ->assertSee($post->list_header_image);
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
}
