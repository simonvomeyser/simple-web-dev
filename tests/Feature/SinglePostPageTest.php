<?php

namespace Tests\Feature;

use App\Post;
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


    /** @test */
    public function a_post_can_be_retrived_with_a_different_filename_than_title()
    {
        $post = factory(Post::class)->create();

        $oldLink = $post->link();
        $this->get($post->link())->assertOk();

        $post->slug = 'something';
        $post->save();
        $newLink = $post->link();
        $this->get($post->link())->assertOk();

        $this->assertNotSame($newLink, $oldLink);
    }
}
