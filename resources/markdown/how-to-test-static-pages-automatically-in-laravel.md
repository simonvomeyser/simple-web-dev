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

I love to write tests - mostly for the "peace of mind" feeling you get. When doing websites that involve a lot of static
pages, I frequently ended up with tests like this

```php
class StaticPagesTest extends TestCase
{
    /** @test */
    public function the_static_pages_work()
    {
        $this->get(route('index'))->assertStatus(200);
        $this->get(route('infos'))->assertStatus(200);
        $this->get(route('about-us'))->assertStatus(200);
        //... repeat x 100
    }
}
```

It should be obvious why this is a not-so-super-genius idea. These pages might change or new pages might be added. I
often forgot pages and usually these tests ended up not providing much confidence anymore.

This should be easier... Laravel knows about your pages and routes right? hmmm...

** INSERT WHAT IF IMAGE **

## The DOM Crawler Idea

I had the idea that maybe Laravel could crawl your frontpage, follow internal links and at least make sure, that they
all work. The idea is not to test any specific behaviour, but to make sure, nothing linked results in a `404` or even
a `500` error.

Introducing: Mighty [Spatie](https://spatie.be) and their [Crawler Package](https://github.com/spatie/crawler)

This package helps you to crawl a URL you give it and finds all links on that page. On top of that work I created a
package that helps you to reliably test static pages in your website like this:

```php
use SimonVomEyser\AutomaticTests\StaticPagesTester

class StaticPagesTest extends TestCase
{
    /** @test */
    public function the_static_pages_work()
    {
       StaticPagesTester::run() 
    }
}
```

in my opinion, this is pound for pound a quite high amount of confidence you get for just one line code.

While I like opinionated packages that go for the 80% use-case, there are quite some options to adjust the package to
your needs:

```php
use SimonVomEyser\AutomaticTests\StaticPagesTester
//...

// Test links in your sitemap and links on these pages
// Only to a depth of 2
StaticPagesTester::create()
   ->url(config('app.url'). '/sitemap.xml')
   ->setMaximumDepth(2)
   ->run();
   
```

You can even test external links on your page!

```php

// Only test external links
ExternalLinksTester::create()
   ->executeJavascript() 
   ->run();
   
```

This will increase your UX and maybe even your [SEO](https://moz.com/blog/does-fixing-broken-links-matter-seo). This is especially helpful with a Blog like this, because old posts might link resources that disappeared.

The configuration options for and more  
