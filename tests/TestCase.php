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
        File::deleteDirectory(base_path('tests/Fixtures/post'));
        File::makeDirectory(base_path('tests/Fixtures/post'), 0755, true);
        parent::setUp();
    }
    protected function tearDown(): void
    {
        File::deleteDirectory(base_path('tests/Fixtures/post'));
        File::cleanDirectory(base_path('tests/Fixtures/post'));
        parent::tearDown();
    }
}
