<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostTest extends TestCase
{
    /** @test */
    public function a_post_can_be_created()
    {
        $post = new Post();

        $post->title = 'A name';

        $this->assertTrue($post->title == 'A name');
    }

    /** @test */
    public function a_post_can_be_saved_and_retrieved()
    {
        $post = new Post();

        $post->title = 'A name';

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
    public function all_posts_are_returned_from_released_scope_when_in_local_development_mode()
    {
        factory('App\Post')->create(['release_date' => '']);
        factory('App\Post')->create(['release_date' => Carbon::tomorrow()]);
        factory('App\Post')->create();

        Config::set('app.env', 'local');

        $this->assertCount(3, Post::released());
    }

    /** @test */
    public function it_returns_the_right_instance_classname()
    {
        $post = new Post();
        $this->assertTrue('Post' === $post->baseName());
        $this->assertTrue('post' === $post->lowerBaseName());
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

    /** @test */
    public function posts_can_be_found_by_their_filename_slug()
    {
        $post = factory(Post::class)->create();

        $foundPost = Post::findBySlug($post->slug());

        $this->assertSame($foundPost->slug(), $post->slug());
    }

    /** @test */
    public function posts_can_also_be_found_by_their_definded_slug()
    {
        $post = factory(Post::class)->create(['slug' => 'this-is-a-slug']);

        $foundPost = Post::findBySlug('this-is-a-slug');

        $this->assertSame($foundPost->slug(), $post->slug());
    }

    /** @test */
    public function a_post_can_be_checked_if_it_exists()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->make();

        $this->assertTrue($post1->exists);
        $this->assertFalse($post2->exists);
    }

    /** @test */
    public function a_view_response_can_be_retrieved_from_an_existing_blade_based_model()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->make();

        $this->assertFalse((bool) $post2->view());
        $this->assertRegExp('/<html.*html>/s', $post1->view());
    }

    /** @test */
    public function a_blade_based_model_is_responsable()
    {
        // todo improve test to actually create ad hoc route
        Route::get('test', function () {
            return factory(Post::class)->create();
        });

        $response = $this->get('test');
        $this->assertRegExp('/<html.*html>/s', $response->getContent());
    }

    /** @test */
    public function a_not_existent_blade_based_model_throws404()
    {
        Route::get('test', function () {
            return factory(Post::class)->make();
        });
        $response = $this->get('test');
        $this->assertTrue(get_class($response->exception) === NotFoundHttpException::class);
    }
}
