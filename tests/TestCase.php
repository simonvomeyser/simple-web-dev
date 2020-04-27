<?php

namespace Tests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function setUp() : void
    {
        parent::setUp();

        Config::set('posts.location', base_path('tests/Fixtures/posts'));
        Config::set('view.paths', array_merge(config('view.paths'), [base_path('tests/Fixtures')]));

        // Cleanup posts folder    
    }
    protected function tearDown() : void
    {
        parent::tearDown();
        
        // Cleanup posts folder    
    }
}
