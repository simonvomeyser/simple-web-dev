<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class SinglePostPageTest extends TestCase
{
    /** @test */
    public function a_post_is_reachable_via_its_filename_slug()
    {
        $post = factory('App\Post')->create();

        $this->get($post->link())
            ->assertSee($post->title)
            ->assertSee(new HtmlString($post->content))
            ->assertSee($post->header_image);
    }
}
