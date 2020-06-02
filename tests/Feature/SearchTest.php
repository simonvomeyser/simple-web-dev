<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /** @test */
    public function the_frontpage_contains_the_search()
    {
        $response = $this->get('/');

        $response->assertSee('Search')->assertSee('<input type="text"', false);
    }
}
