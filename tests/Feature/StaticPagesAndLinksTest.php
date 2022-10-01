<?php

namespace Tests\Feature;

use App\Markdown\MarkdownPost;
use SimonVomEyser\LaravelAutomaticTests\StaticPagesTester;
use Tests\TestCase;

class StaticPagesAndLinksTest extends TestCase
{
    public function testAllInternalPagesReachableOnFrontpage()
    {
        MarkdownPost::unfake();

        StaticPagesTester::create()
            ->ignoreQueryParameters()
            ->ignorePageAnchors()
            ->run();

    }

    public function testAllFakedPagesAreReachable()
    {
        MarkdownPost::fake();

        StaticPagesTester::create()
            ->ignoreQueryParameters()
            ->ignorePageAnchors()
            ->run();
    }

}
