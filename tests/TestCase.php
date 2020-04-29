<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function setUp(): void
    {
        $this->refreshApplication();
        File::deleteDirectory(base_path('tests/Fixtures/posts'));
        File::makeDirectory(base_path('tests/Fixtures/posts'), 0755, true);
        parent::setUp();
    }
    protected function tearDown(): void
    {
        parent::tearDown();

        File::deleteDirectory(base_path('tests/Fixtures/posts'));
        File::cleanDirectory(base_path('tests/Fixtures/posts'));
    }
}
