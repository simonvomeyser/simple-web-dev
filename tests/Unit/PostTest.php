<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Carbon;


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
    public function attributes_can_be_overwritten()
    {
        $post = factory(Post::class)->make(['title' => 'test']);

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function many_can_be_made_via_factory()
    {
        $posts = factory(Post::class, 3)->make();

        $this->assertCount(3, $posts);
    }

    /** @test */
    public function it_can_be_created_via_a_factory()
    {
        $post = factory(Post::class)->create();

        $savedPost = Post::all()->first();

        $this->assertNotNull($savedPost);

        $this->assertEquals($post->title, $savedPost->title);
    }

    /** @test */
    public function it_returns_a_link_to_itself()
    {
        $post = factory(Post::class)->make();

        $this->assertNotNull($post->link());
    }

    /** @test */
    public function only_released_posts_are_returned_from_released_scope()
    {
        factory('App\Post')->create(['release_date' => '']);
        factory('App\Post')->create(['release_date' => Carbon::tomorrow()]);
        factory('App\Post')->create();

        $this->assertCount(1, Post::released());
    }

    /** @test */
    public function released_posts_are_sorted_by_release_date()
    {
        $postYearAgo = factory('App\Post')->create(['release_date' => Carbon::now()->subYear()]);
        $postYesterday = factory('App\Post')->create(['release_date' => Carbon::yesterday()]);
        factory('App\Post')->create(['release_date' => Carbon::now()->subMonth()]);

        $posts = Post::released();

        $this->assertTrue($posts->first()->link() === $postYesterday->link());
        $this->assertTrue($posts->last()->link() === $postYearAgo->link());
    }
}
