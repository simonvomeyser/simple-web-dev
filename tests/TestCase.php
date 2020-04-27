<?php

namespace Tests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function setUp(): void
    {
        parent::setUp();

        Config::set('posts.location', base_path('tests/Fixtures/posts'));

        // todo Cleanup posts folder    
    }
    protected function tearDown(): void
    {
        parent::tearDown();

        // todo Cleanup posts folder    
    }
}
