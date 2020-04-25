<?php

namespace Tests\Unit;

use App\Post;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function a_post_can_be_created()
    {
        $post = new Post();

        $post->name = "A name";

        $this->assertTrue($post->name == "A name");
    }
}
