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
}
