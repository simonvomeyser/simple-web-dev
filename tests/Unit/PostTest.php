<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;


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
}
