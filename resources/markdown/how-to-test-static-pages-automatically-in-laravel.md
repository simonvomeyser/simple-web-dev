---
title: How to test static pages automatically in Laravel
release_date: 22-10-07
slug: how-to-test-static-pages-automatically-in-laravel
excerpt: >-

    I developed a way to automatically crawl and test big parts of your Laravel application.
    
    With just one line of code, you can now write a "peace of mind" test that gives you a lot of confidence.

tags:
    - testing
    - laravel
    - devops

header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1664632605/laravel-automatic-tests/header-automatic-tests.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1664632605/laravel-automatic-tests/header-automatic-tests.png
---
<small>Tested on Laravel `9.x` </small>

I love to write tests - mostly for the "peace of mind" feeling you get when making changes. When working on websites that involve a lot of static pages – like simple portfolio projects – I frequently ended up with tests like this:

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

It should be obvious why this is a not-so-super-genius idea. Pages change or new pages might be added. I often forgot all of them and usually these tests ended up not providing much confidence anymore.

Also, what happens, if you link to a broken page or not existing page from one of your pages?

This should be easier... I just want a quick "did I destroy something" check... and hey, Laravel knows about your pages and routes right? hmmm...

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1664633884/laravel-automatic-tests/whatif.png)

Shameless plug:

> My package [Laravel Automatic Tests](https://github.com/simonvomeyser/laravel-automatic-tests)

This one line of code tests **all** your static pages reachable from your frontpage, recursively! 🎉

```php
/** @test */
public function the_static_pages_work()
{
    StaticPagesTester::create()->run();
}
```

...in my opinion, this is (pound for pound) a quite high amount of confidence you get for just one line code.

## A few more details

I had the idea that maybe Laravel test could crawl your page, follow internal links and at least make sure, that they all work. 

The idea is not to test any specific behaviour, but to make sure, nothing linked results in a `4xx` or even a `5xx` error. It also lowers the barrier of entry to testing and that I would have at least a little layer of security for projects with no extensive testsuite.

I first experimented with the [Crawler Package](https://github.com/spatie/crawler) from [Spatie](https://spatie.be), and this might be a cool solution for end-to-end tests. But I had to remember, that the default *feature tests* of Laravel simply news up the application without getting a real server/browser involved. 

I therefore ended up writing a small crawler based on the `TestResponses` of Laravel to provide the functionality I was looking  for. This also explains why this package currently only crawls **internal** links.

There are quite a few configuration options since I needed them in my own projects. This is an example of some of them:

```php
//...
use SimonVomEyser\LaravelAutomaticTests\StaticPagesTester;

class StaticPagesTest extends TestCase
{
    /** @test */
    public function the_static_pages_work()
    {
        $spt = StaticPagesTester::create()
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
            
        dump(count($spt->urisHandled)); // Outputs the number uris found and tested
    }
}
```

This test starts from the url `/home` checks only the base url and ignores things like query parameters and page anchors (`?search=lorem`, `#contact`). It even adds an additional assertion that checks, that all uris starting with `/admin` explicitly return a redirect. 

## Caveats

This package is more of a proof of concept for me, and something I needed for simpler pages to quickly add a testing layer.

Sadly, this *does not work with JavaScript* – it basically has the same limitations that default Laravel feature test have. So no testing SPAs or [Ineartia.js](https://inertiajs.com/) projects

There is a [roadmap](https://github.com/simonvomeyser/laravel-automatic-tests#roadmap) you can check out for the things that could be a cool addition to this package.

That's all for this post, I just wanted to explain the reasoning behind the decisions ... and of course promote my OSS Work a little 😅


best
Simon
