<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\HtmlString;

class SinglePostPageTest extends TestCase
{
    /** @test */
    public function isReachableViaItsFilenameSlug()
    {
        $post = factory('App\Post')->create();

        $this->get($post->link())
            ->assertSee($post->title)
            ->assertSee(new HtmlString($post->content))
            ->assertSee($post->header_image);
    }
}
