<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;


class PostTest extends TestCase
{
    /** @test */
    public function a_post_can_be_created()
    {
        $post = new Post();

        $post->title = "A name";

        $this->assertTrue($post->title == "A name");
    }

    /** @test */
    public function a_post_can_be_saved_and_retrieved()
    {
        $post = new Post();

        $post->title = "A name";

        $post->save();

        $savedPost = Post::all()->first();

        $this->assertNotNull($savedPost);

        $this->assertEquals($post->title, $savedPost->title);
    }

    /** @test */
    public function attributes_can_be_filled()
    {
        $post = new Post(['title' => 'something']);

        $this->assertTrue($post->title === 'something');
    }

    /** @test */
    public function it_can_be_made_via_a_factory()
    {
        $post = factory(Post::class)->make();

        $this->assertNotNull($post->title);
    }

    /** @test */
    public function many_can_be_made_via_factory()
    {
        $posts = factory(Post::class, 3)->make();

        $this->assertCount(3, $posts);
    }
}
