<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Markdown\MarkdownPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithFaker;

class MarkdownPostTest extends TestCase
{
    use WithFaker;

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
    }

    /** @test */
    public function all_posts_are_returned_from_released_scope_when_in_local_development_mode()
    {
    }

    /** @test */
    public function it_returns_the_right_instance_classname()
    {
    }

    /** @test */
    public function released_posts_are_sorted_by_release_date()
    {
    }

    /** @test */
    public function posts_can_be_found_by_their_filename_slug()
    {
    }

    /** @test */
    public function posts_can_also_be_found_by_their_definded_slug()
    {
    }

    /** @test */
    public function a_post_can_be_checked_if_it_exists()
    {
    }

    /** @test */
    public function a_view_response_can_be_retrieved_from_an_existing_blade_based_model()
    {
    }

    /** @test */
    public function a_blade_based_model_is_responsable()
    {
    }

    /** @test */
    public function a_not_existent_blade_based_model_throws404()
    {
    }

    /** @test */
    public function it_estimates_reading_time()
    {
    }
}
