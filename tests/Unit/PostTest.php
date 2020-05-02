<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function aPostCanBeCreated()
    {
        $post = new Post();

        $post->title = 'A name';

        $this->assertTrue($post->title == 'A name');
    }

    /** @test */
    public function aPostCanBeSavedAndRetrieved()
    {
        $post = new Post();

        $post->title = 'A name';

        $post->save();

        $savedPost = Post::all()->first();

        $this->assertNotNull($savedPost);

        $this->assertEquals($post->title, $savedPost->title);
    }

    /** @test */
    public function attributesCanBeFilled()
    {
        $post = new Post(['title' => 'something']);

        $this->assertTrue($post->title === 'something');
    }

    /** @test */
    public function itCanBeMadeViaAFactory()
    {
        $post = factory(Post::class)->make();

        $this->assertNotNull($post->title);
    }

    /** @test */
    public function attributesCanBeOverwritten()
    {
        $post = factory(Post::class)->make(['title' => 'test']);

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function manyCanBeMadeViaFactory()
    {
        $posts = factory(Post::class, 3)->make();

        $this->assertCount(3, $posts);
    }

    /** @test */
    public function itCanBeCreatedViaAFactory()
    {
        $post = factory(Post::class)->create();

        $savedPost = Post::all()->first();

        $this->assertNotNull($savedPost);

        $this->assertEquals($post->title, $savedPost->title);
    }

    /** @test */
    public function itReturnsALinkToItself()
    {
        $post = factory(Post::class)->make();

        $this->assertNotNull($post->link());
    }

    /** @test */
    public function onlyReleasedPostsAreReturnedFromReleasedScope()
    {
        factory('App\Post')->create(['release_date' => '']);
        factory('App\Post')->create(['release_date' => Carbon::tomorrow()]);
        factory('App\Post')->create();

        $this->assertCount(1, Post::released());
    }

    /** @test */
    public function itReturnsTheRightInstanceClassname()
    {
        $post = new Post();
        $this->assertTrue('Post' === $post->baseName());
        $this->assertTrue('post' === $post->lowerBaseName());
    }

    /** @test */
    public function releasedPostsAreSortedByReleaseDate()
    {
        $postYearAgo = factory('App\Post')->create(['release_date' => Carbon::now()->subYear()]);
        $postYesterday = factory('App\Post')->create(['release_date' => Carbon::yesterday()]);
        factory('App\Post')->create(['release_date' => Carbon::now()->subMonth()]);

        $posts = Post::released();

        $this->assertTrue($posts->first()->link() === $postYesterday->link());
        $this->assertTrue($posts->last()->link() === $postYearAgo->link());
    }

    /** @test */
    public function postsCanBeFoundByTheirSlug()
    {
        $post = factory(Post::class)->create();

        $foundPost = Post::findBySlug($post->slug());

        $this->assertSame($foundPost->slug(), $post->slug());
    }

    /** @test */
    public function aPostCanBeCheckedIfItExists()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->make();

        $this->assertTrue($post1->exists);
        $this->assertFalse($post2->exists);
    }

    /** @test */
    public function aViewResponseCanBeRetrievedFromAnExistingBladeBasedModel()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->make();

        $this->assertFalse((bool) $post2->view());
        $this->assertRegExp('/<html.*html>/s', $post1->view());
    }

    /** @test */
    public function aBladeBasedModelIsResponsable()
    {
        Route::get('test', function () {
            return factory(Post::class)->create();
        });

        $response = $this->get('test');
        $this->assertRegExp('/<html.*html>/s', $response->getContent());
    }

    /** @test */
    public function aNotExistentBladeBasedModelThrows404()
    {
        Route::get('test', function () {
            return factory(Post::class)->make();
        });
        $response = $this->get('test');
        $this->assertTrue(get_class($response->exception) === NotFoundHttpException::class);
    }
}
