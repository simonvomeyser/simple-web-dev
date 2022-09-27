<?php

namespace Tests\Feature;

use SimonVomEyser\LaravelAutomaticTests\Classes\StaticPagesTester;
use SimonVomEyser\LaravelAutomaticTests\Facades\LaravelAutomaticTests;
use Tests\TestCase;

class StaticPagesAndLinksTest extends TestCase
{
    public function testAllInternalPagesReachableOnFrontpage()
    {
        StaticPagesTester::create()
            ->ignoreQueryParameters()
            ->ignorePageAnchors()
            ->run();
    }

}
