<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Markdown\MarkdownPost;
use Illuminate\Foundation\Testing\WithFaker;


class SearchTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        MarkdownPost::fake();
    }

    /** @test */
    public function the_frontpage_contains_the_search()
    {
        $response = $this->get('/');

        $response->assertSee('Search')->assertSee('<input type="text"', false);
    }

    /** @test */
    public function visiting_the_frontpage_with_query_param_causes_search()
    {
        $post = new MarkdownPost('post-number-one.md');
        $postTwo = new MarkdownPost('post-number-two.md');

        $this->get('/?q=' . urlencode('Post number one'))
            ->assertSee($post->title)
            ->assertDontSee($postTwo->title);
    }

    /** @test */
    public function the_searched_word_can_be_seen()
    {
        $query = 'Post number one';

        $this->get('/?q=' . urlencode('Post number one'))
            ->assertSee($query);
    }
}
