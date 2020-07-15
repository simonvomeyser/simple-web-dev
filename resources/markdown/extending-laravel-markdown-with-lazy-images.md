---
title: Extending Laravel's league/commonmark Markdown - adding lazy images
release_date: Today
slug: extending-laravel-markdown-with-lazy-images
excerpt:
tags: 
    - Backend
    - Tutorial
header_image: https://placehold.it/1024x768 
list_image: https://placehold.it/1024x768 
---

Laravel makes use of a lot of powerful third party libraries and assembles them into a badass unit like Captain America does with the Avengers. 

@todo taylor as captain america

Parts of the Symphony Framework provide solid low level functionality and testing is entrusted to the awesome folks at PHPUnit.

@todo link articles, on version differences

I also read some articles about the power of the Laravel Markdown Renderer [here](https://medium.com/@DarkGhostHunter/laravel-there-is-a-markdown-parser-and-you-dont-know-it-5f523e22121e)  which recently switched to the Commonmark Library from Parsedown https://github.com/laravel/framework/pull/30982

https://laracasts.com/discuss/channels/laravel/best-way-to-render-markdown-in-views

@todo end link articles

While I was implementing simple-web.dev I wanted to use Laravel to have full control about the implementation - and I definitely wanted to write the posts in Markdown to keep them in git. I found that Laravel already ships with a really powerful library for Markdown parsing called [league/commonmark](https://github.com/thephpleague/commonmark) and wanted to make use of that.

I will go over a few necessary customizations and how I implemented them since I found that a little confusing at first.

I will also show an easy extension example by adding lazy loaded images to my posts, a feature all blogs should have - me in particular since I use way too many childish GIFs.

@todo Add childish gif

## Using Laravel's Commonmark implementation

By the time of writing, Laravel uses its internal Markdown parser for one purpose only: To make [Markdown Mailables](/@todo) possible. 

These Mailables are a weird mix of Blade and Markdown syntax - the Blade template is rendered by the class `\Illuminate\Mail\Markdown` making heavy use of the [sections and slots](@todo). 

@todo maybe add a gif "oh it's so pretty ugly child gif"

Hidden inside of these blade sections rendering the mail's layout there are direct calls to the one function we are looking for:

```php

// Will render Markdown, this creates "<h1>Hello</h1>
echo \Illuminate\Mail\Markdown::parse('# Hello');

```

With this static method we can already use the internal Markdown parser for our own markdown files:

```php
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\File;

$html = Markdown::parse(File::get('file.md'));
```

Now that's pretty 😍 - but we are bound to the configuration Laravel dictates, so let's not stop here.
 
## Customize it

As far as I looked into it the `Illuminate\Mail\Markdown` class is not bound into the service container, there is no Facade and no quick way to replace it. That's no drama though, this class is specialized in rendering *mails* for Laravel so why toy with it?

The most comfortable way I found is to customize the underlying ![league/commonmark](https://github.com/thephpleague/commonmark) implementation is to use it like Laravel does it:

```php
$environment = Environment::createCommonMarkEnvironment();

$environment->addExtension(new TableExtension);

$converter = new CommonMarkConverter([
    'allow_unsafe_links' => false,
], $environment);

$html = $converter->convertToHtml('Your Markdown text');
```

Here we can already see how to customize the environment to our heart's liking 

## Extend it
