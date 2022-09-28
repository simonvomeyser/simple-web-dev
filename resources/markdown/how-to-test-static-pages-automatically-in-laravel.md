---
title: How to test static pages automatically in Laravel
release_date: now
slug: how-to-test-static-pages-automatically-in-laravel
excerpt: >-

    The excerpt of this markdown post goes here

    Another line

tags:
    - tag1
    - tag2

header_image: >-
  https://via.placeholder.com/1024x768
list_image: >-
  https://via.placeholder.com/1024x768
---
<small>Tested on Laravel `9.x` </small>

I love to write tests - mostly for the "peace of mind" feeling you get. When doing websites that involve a lot of static pages I frequently ended up with tests like this

```php
class StaticPagesTest extends TestCase
{
    /** @test */
    public function the_static_pages_work()
    {
        $this->get(route('index'))->assertStatus(200);
        $this->get(route('infos'))->assertStatus(200);
        $this->get(route('about-us'))->assertStatus(200);
        $this->get(route('projects'))->assertStatus(200);
        $this->get(route('privacy'))->assertStatus(200);
        //... repeat x 100
    }
}
```

It should be obvious why this is a not-so-super-genius idea. These pages might change or new pages might be added. I often forgot pages and usually these tests ended up not providing much confidence anymore.

This should be easier... Laravel knows about your pages and routes right? hmmm...

** INSERT WHAT IF IMAGE **

Presenting (shameless plug) [my package Laravel Automatic Tests](https://github.com/simonvomeyser/laravel-automatic-tests)

This tests *all* your static pages reachable from your frontpage 🎉

```php
//...
use SimonVomEyser\LaravelAutomaticTests\StaticPagesTester;

class StaticPagesTest extends TestCase
{
    /** @test */
    public function the_static_pages_work()
    {
        StaticPagesTester::create()
            ->startFromUrl('/home')
            ->ignorePageAnchors()
            ->skipDefaultAssertion()
            ->addAssertion(function($response, $uri) {
                // Example: check for redirects only when accessing admin area
                if(str_contains($uri, '/admin')) {
                    $response->assertRedirect()
                }
            })
            ->run();
    }
}
```

...in my opinion, this is pound for pound a quite high amount of confidence you get for just one line code.

## A few more details

I had the idea that maybe Laravel could crawl your frontpage, follow internal links and at least make sure, that they all work. The idea is not to test any specific behaviour, but to make sure, nothing linked results in a `4xx` or even a `5xx` error.

I first experimented with the [Crawler Package](https://github.com/spatie/crawler) from [Spatie](https://spatie.be), and this might be a cool solution for end-to-end tests. But I had to remember, that the default *feature tests* of Laravel simply new up the application without getting a real server/browser involved. 

I therefore ended up writing a small crawler based on the `TestResponses` of Laravel to provide the functionality I was looking  for. That is also the reason, that this package for now only can find *internal* links.

There are quite a few configuration options since I needed them in few of my projects. 

```php
//...
use SimonVomEyser\LaravelAutomaticTests\StaticPagesTester;

class StaticPagesTest extends TestCase
{
    /** @test */
    public function the_static_pages_work()
    {
        StaticPagesTester::create()
            ->startFromUrl('/home')
            ->ignoreQueryParameters()
            ->ignorePageAnchors()
            ->addAssertion(function($response, $uri) {
                // Example: check for redirects only when accessing admin area
                if(str_contains($uri, '/admin')) {
                    $response->assertRedirect()
                }
            })
            ->run();
    }
}
```

That's all for this post, I just wanted to explain the reasoning behind the decisions ... and of course promote my OSS Work a little 😅


best
Simon
