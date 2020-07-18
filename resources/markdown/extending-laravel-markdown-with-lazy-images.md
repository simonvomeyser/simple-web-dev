---
title: Using Laravel's Markdown parser for a personal blog - and adding lazy images
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
https://github.com/laravel/framework/pull/30982

@todo end link articles

While I was implementing simple-web.dev I wanted to use Laravel to have full control about the implementation - and I definitely wanted to write the posts in Markdown to keep them in version control. 

I found that Laravel already ships with a really powerful library for Markdown parsing called [league/commonmark](https://github.com/thephpleague/commonmark) and wanted to make use of that.

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

$html = $converter->convertToHtml('Your Markdown String');
```

Here we can already see how to customize the environment to our heart's liking with the possibilities the [underlying library provides](https://commonmark.thephpleague.com/1.4/customization/overview/).

You can already see things that Laravel does:

- Adding a table Extension to provide the table component described in the [docs](https://laravel.com/docs/7.x/mail)
- Defaulting to not allow unsafe links, a precaution to prevent potential exploits, and the whole reason the markdown renderer was [changed](https://github.com/laravel/framework/pull/30982) by Taylor Otwell in 6.x in the first place.

You can do many more things from here without even diving into depth, just a few examples of things I added to render the posts of this page:

@todo maybe add images?

- Adding the [External Link Extension](https://commonmark.thephpleague.com/1.4/extensions/external-links/) to have almost all links open in new windows, except the ones pointing to the same site
- Adding the [Heading Permalinks Extension](https://commonmark.thephpleague.com/1.4/extensions/heading-permalinks/) to be able to link directly to headings 

Nearly everything can be achieved fairly quickly with the tools we already have on board, but what can you do when there is not extension available for the functionality you want?

## Extend it!

I wanted to add lazy images to my posts since it is a [common best practice](https://developers.google.com/search/docs/guides/lazy-loading) - but I did not find an extension for it.

The TL;DR is: When you are looking for exactly that functionality you can [download my extension](@todo) - If you want to see how I did it and maybe want to create your own functionality keep on reading :)

### Diving in

If you are used coding in Laravel the `League\CommonMark` library feels a bit *old school* . It confused me at first that I needed to create an environment, add the extensions to this environment, then add the environment to the parser... and then add config for the extensions to the parser, not the environment. 
 
I don't mean to make a derogatory comment here though - the library is insanely flexible the authors and maintainers did awesome work. You can extend almost everything, listen for events and even access the generated data structure (AST) before it is rendered to HTML.

@todo side note wtf is a AST
 
The library features the possibility to add *parsers* and *renderes* on the created environment. Parsing means "recognizing a pattern in markdown and add it to the things that should be rendered". Rendering happens after the parsing is complete and means actually transforming the data (AST) into an HTML string.

@todo what meme

It gets even a little more confusing since the library distinguishes between *inline* and *block* handling, both have respective *parsers* and *renderes*. 

@todo talk about how you could go into depth

If you need to really parse new syntax like transforming twitter handles into links to the person's profile, there is [a tutorial](https://commonmark.thephpleague.com/1.3/customization/inline-parsing/#inline-parser-examples) for that.

I will stop here since I found a better way to achieve my goal with lazy images.

But what we want to do is *extending* an already parsed 'inline' element, an image, with classes and attributes to make it lazy.

### Creating our Extension

Most of the core extensions work in quite a similar, straightforward way: They don't add parsers or renderers, they listen for the `DocumentParsedEvent` and traverse the already created data structure to add a few things. 

The [External Links Extension](https://commonmark.thephpleague.com/1.3/extensions/external-links/) adds things like `target="_blank"` for example.

I ran into a problem with this approach since I wanted my lazy image extension to not only add things like an `loading="lazy"` attribute, something that hopefully will be sufficient [in the future](https://web.dev/native-lazy-loading/). I wanted to support the [various lazy loading libraries](https://www.cssscript.com/top-10-lazy-loading-javascript-libraries/) out there with configuration options.

Sadly, the really important work like checking for secure URLs is not done in the parser, it's done in the renderer, right before the image data get's turned into HTML. I had no access or possibility to empty the `src` attribute, something vital for most lazy loading libraries.

It is possible to simply copy the content of the `League\CommonMark\Inline\Renderer\ImageRenderer`, adding my own functionality and adding this Renderer with a higher priority

```php

$environment->addInlineRenderer( 
    'League\CommonMark\Inline\Element\Image', 
    new LazyImageRenderer(),
    9000 // Priority, the original is added with 0, we need to go higher, over 9000!
);
    
``` 
That might be a viable option for a quick and dirty solution, but I think that's no way to live your life. The native `ImageRenderer` might change in the future, receive security updates and people using our extension would not benefit from those. 

I needed the processing inside the native image renderer to run and then tag on our functionality. I thought of simply extending the class, but the library authors declared almost all classes as final - something I saw many discussions about, but it was the first time it affected me.

@todo add screenshot of taylor classes final 
https://twitter.com/taylorotwell/status/1237068965177892864?lang=en
https://matthiasnoback.nl/2018/09/final-classes-by-default-why/
https://ocramius.github.io/blog/when-to-declare-classes-final/
https://verraes.net/2014/05/final-classes-in-php/
@todo end add screenshot of taylor classes final 

I still have no final (eheh) opinion about this, but in this case it would have been helpful and made sense in my naive understanding. This also has been discussed in the [issues](https://github.com/thephpleague/commonmark/issues/379) and I get the argument though.

I ended up not subclassing but calling the original renderer and modifying the output in a composition over inheritance approach.

The actual *programming* that needed to be done was quite simple, but that is the whole reason I wanted to write this post. Usually the implemention of a feature is way less complicated than wrapping your head around the way a library wants to be extended.

```php
$baseImage = $this->baseImageRenderer->render($inline, $htmlRenderer);

// Provide modern browser
$baseImage->setAttribute('loading', 'lazy');
// Set the src to the already 'secure' src of the base image
$baseImage->setAttribute('data-src', $baseImage->getAttribute('src'));
// Empty the original src
$baseImage->setAttribute('src', ''); 

return $baseImage;
``` 


## Closing

Extending and tailoring the Libarary to your needs is fairly straightforward once you got your feed off the ground.

After all I found the `phpleague/commonmark` package to be well-structured and easy to extend, even if the way to use it is a little confusing at first. That might only be a matter of taste though, I know quite a few developers who prefer a more expressive API instead of hidden complexity.

I hope this little exploration helps someone out there trying to extend Laravel's Markdown functionality! 

 

# More todo

- 
