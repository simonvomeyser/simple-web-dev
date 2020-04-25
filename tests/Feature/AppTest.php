<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppTest extends TestCase
{
    /** @test */
    public function the_app_is_reachable()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
