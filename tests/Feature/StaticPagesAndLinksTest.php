<?php

namespace Tests\Feature;

use SimonVomEyser\LaravelAutomaticTests\Facades\LaravelAutomaticTests;
use Tests\TestCase;

class StaticPagesAndLinksTest extends TestCase
{
    public function testBasic()
    {
        LaravelAutomaticTests::sayHello();
    }
}
