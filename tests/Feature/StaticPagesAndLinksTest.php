<?php

namespace Tests\Feature;

use SimonVomEyser\LaravelAutomaticTests\StaticPagesTester;
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
