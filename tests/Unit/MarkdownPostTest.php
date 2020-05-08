<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Markdown\MarkdownPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Mail\Markdown;

class MarkdownPostTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        MarkdownPost::fake();
    }

    /** @test */
    public function a_post_can_be_created_from_a_markdown_file()
    {
        $post = new MarkdownPost('post-number-one.md');

        $this->assertNotNull($post);
    }

    /** @test */
    public function it_parses_the_frontmatter_data()
    {
        $post = new MarkdownPost('post-number-one.md');

        $this->assertNotEmpty($post->title);
        $this->assertNotEmpty($post->content);
        $this->assertNotEmpty($post->excerpt);
        $this->assertNotEmpty($post->release_date);
        $this->assertNotEmpty($post->slug);
        $this->assertNotEmpty($post->tags);
        $this->assertNotEmpty($post->header_image);
        $this->assertNotEmpty($post->list_image);
    }

    /** @test */
    public function it_parses_special_frontmatter_data_in_the_right_datatypes()
    {
        $post = new MarkdownPost('post-number-one.md');

        $this->assertTrue(Carbon::class === get_class($post->release_date));
        $this->assertTrue(is_array($post->tags));
        $postTwo = new MarkdownPost('post-number-two.md');
        $this->assertTrue(is_array($postTwo->tags));
        $this->assertTrue(empty($postTwo->tags));
    }

    /** @test */
    public function it_parses_the_markdown_content_to_html()
    {
        $post = new MarkdownPost('post-number-one.md');

        $this->assertStringContainsString('<a href=', $post->content);
        $this->assertStringContainsString('<p>', $post->content);
        $this->assertStringContainsString('<h2>', $post->content);
    }

    /** @test */
    public function it_returns_a_link_to_itself()
    {
        $post = new MarkdownPost('post-number-one.md');

        $this->assertStringContainsString(config('app.url'), $post->getLink());
    }

    /** @test */
    public function all_posts_can_be_retrieved()
    {
        $posts = MarkdownPost::all();

        $filesInFixtures = File::allFiles(MarkdownPost::getFolderPath());

        $this->assertCount(count($filesInFixtures), $posts);
    }

    /** @test */
    public function only_released_posts_are_returned_from_released_scope()
    {
        $releasedPosts = MarkdownPost::released();

        foreach ($releasedPosts as $post) {
            $this->assertTrue($post->release_date->isPast());
        }
    }

    /** @test */
    public function released_posts_are_sorted_by_release_date()
    {
        $posts = MarkdownPost::released();

        $this->assertTrue($posts->first()->release_date->isAfter($posts->last()->release_date));
    }

    /** @test */
    public function posts_can_be_found_by_their_slug()
    {
        $postBySlug = MarkdownPost::find('post-number-one-has-a-long-slug');
        $post = new MarkdownPost('post-number-one.md');

        $this->assertEquals($postBySlug->content, $post->content);
    }


    /** @test */
    public function it_estimates_reading_time()
    {
        $post = new MarkdownPost('post-number-one.md');

        $this->assertIsInt($post->readingTime());
    }

    /** @test */
    public function the_returned_posts_have_incrementing_keys_stating_with_0()
    {
        $posts = MarkdownPost::all();
        $i = 0;

        foreach ($posts as $post) {
            $this->assertArrayHasKey($i, $posts);
            $i++;
        }

        $i = 0;
        $releasedPosts = MarkdownPost::released();
        foreach ($releasedPosts as $post) {
            $this->assertArrayHasKey($i, $posts);
            $i++;
        }
    }
}