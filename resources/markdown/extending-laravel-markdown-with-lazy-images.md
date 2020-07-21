---
title: Using Laravel's Markdown parser for a blog - and adding lazy images
release_date: Today
slug: extending-laravel-markdown-with-lazy-images
excerpt:
tags: 
    - Backend
    - Tutorial
header_image: https://placehold.it/1024x768 
list_image: https://placehold.it/1024x768 
---

@todo taylor as captain america

Laravel makes use of a lot of powerful third party libraries and assembles them into a badass unit like Captain America does with the Avengers. 

Parts of the Symphony Framework provide solid low level functionality and testing is entrusted to the awesome folks at PHPUnit.

I found that Laravel also ships with a really powerful library for Markdown parsing called [commonmark](https://github.com/thephpleague/commonmark) and wanted to make use of that implementing this blog.

I will go over using and customizing this library, something I found a little confusing at first. I will also show how to implement an extension by adding lazy loaded images to my posts, a feature all blogs should have - me in particular since I use way too many childish GIFs.

@todo Add childish gif

## Using it

By the time of writing, Laravel uses its internal Markdown parser for one purpose only: To make [Markdown Mailables](https://laravel.com/docs/7.x/mail#markdown-mailables) possible. 

These Mailables are a weird mix of Blade and Markdown syntax - the Blade template is rendered by the class `\Illuminate\Mail\Markdown` making heavy use of the [sections and slots](@todo). 

@todo maybe add a gif "oh it's so pretty ugly child gif"

Hidden inside of these blade sections there are direct calls to the function we are looking for:

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
 
## Configuring it

The Markdown class is specialized in rendering mails for Laravel, so why toy with it, we could configure it our self.

<sidenote heading="Directly using a core library">

The Markdown rendering class is not bound to the service container or hidden behind an interface. For Laravel there is no sense in offering a sophisticated abstraction if the functionality is only used in one place.

For us in relying on the concrete library this means our code might break if the Laravel core team decides to switch the underlying markdown library. For now this is the most approachable solution though, just be wary of for this.

</sidenote>

The most comfortable customize the underlying [league/commonmark](https://github.com/thephpleague/commonmark) implementation is to use it like Laravel does it:

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;

$environment = Environment::createCommonMarkEnvironment();

$environment->addExtension(new TableExtension);
$converter = new CommonMarkConverter([
    'allow_unsafe_links' => false,
], $environment);

$html = $converter->convertToHtml('Your **Markdown** String');

```

You can already see things that Laravel customizes:

- Adding a table Extension to provide the table component described in the [docs](https://laravel.com/docs/7.x/mail)
- Defaulting to not allow unsafe links, a precaution to prevent potential exploits, and the whole reason the markdown renderer was [changed](https://github.com/laravel/framework/pull/30982) in Laravel 6.x

You can do [many more customizations](https://commonmark.thephpleague.com/1.4/customization/overview/) without even diving into depth, I added the [External Link Extension](https://commonmark.thephpleague.com/1.4/extensions/external-links/) to have links open in new windows

Nearly everything can be achieved fairly quickly with the tools we already have on board, but what can you do when there is not extension available for the functionality you want?

## Extend it!

I wanted to add lazy images to my posts since it is a [common best practice](https://developers.google.com/search/docs/guides/lazy-loading) - but I did not find an extension for it.

**The TL;DR is**: 

When you are only looking for lazy images you can [download my extension](https://github.com/simonvomeyser/commonmark-ext-lazy-image/)
 
 If you want to see how I did it and maybe want to create your own extension keep on reading!

### Diving in

If you are used coding in Laravel the `League\CommonMark` library feels a bit *old school* . The setup and the configuration confused me at first. 
 
I don't mean to make a derogatory comment here though - the library is insanely flexible the authors and maintainers did good work. You can extend almost everything and even access the generated data structure (AST) before it is rendered to HTML.

<sidenote heading="WTH is a AST?">

That's short for Abstract Syntax Tree - something that confused me multiple times since it could mean *everything*

Just think of it as a data structure representing the markdown file, that could be an array for lines and in there a nested array for words.

It's not *exactly* what happens since the there are a lot of custom objects involved, but you hopefully get the idea.

</sidenote>
 
The library uses the concept of *parsers* and *renderes* . Parsing means "recognizing a pattern in markdown and add it to the things that should be rendered". Rendering happens after the parsing is complete and means actually transforming the AST into an HTML string.

It gets even a little more confusing since the library distinguishes between *block* (paragraphs) and *inline* (images, bold text) handling, both have respective *parsers* and *renderes*. 

@todo what meme

I will not go more into depth here because in many cases you will not write your own versions of these.

If you need to really parse new syntax like transforming twitter handles into links to the person's profile, there is a good [tutorial](https://commonmark.thephpleague.com/1.3/customization/inline-parsing/#inline-parser-examples) for that. This new parser creates a link in the AST that is later rendered by the native link renderer.

### Creating our Extension

Most of the core extensions work in a understandable way: They don't add parsers or renderers, they just change the already created data structure to add a few things. 

Since I wanted my lazy image extension to not only add things like an `loading="lazy"` attribute but also to support [lazy loading libraries](https://www.cssscript.com/top-10-lazy-loading-javascript-libraries/) by removing the `src` attribute and adding that in a `data-` attribute I had problem: 

The important work of creating the image HTML like checking if it has a secure URL is implemented in the renderer, not in the parser.

In first naive approach was to simply copy the original renderer, adding my own functionality and making the core use my class instead of the original:

```php
//...

$environment->addInlineRenderer( 
    'League\CommonMark\Inline\Element\Image', 
    new LazyImageRenderer(),
    42 // Priority, original is 0, we just need to go higher
);
``` 

That's no way to live your life. The native `ImageRenderer` might change in the future, receive security updates and people using our extension would not benefit from those. 

I needed the processing inside the native image renderer to run before my functionality. Extending was not an option because the classes are marked as final - something I saw many [discussions](https://twitter.com/taylorotwell/status/1237068965177892864) about, but it was the first time it affected me.

@todo add screenshot of taylor classes final 
https://twitter.com/taylorotwell/status/1237068965177892864?lang=en
https://matthiasnoback.nl/2018/09/final-classes-by-default-why/
https://ocramius.github.io/blog/when-to-declare-classes-final/
https://verraes.net/2014/05/final-classes-in-php/
@todo end add screenshot of taylor classes final 

I still have no final (eheh) opinion about this. This is also has been discussed in the [issues](https://github.com/thephpleague/commonmark/issues/379) and I get the argument and respect the package author's decision though.

I ended up not subclassing but calling the original renderer and modifying the output in a composition over inheritance approach. To be a bit more concise: My own class just creates the core image renderer, gets it's output and changes it. Then you just tell the library to use your renderer instead of the original one, like in the first naive example.

The actual *programming* that needed to be done after that was quite simple in the end, but that is the whole reason I wanted to write this post. Usually the implementation of a feature is way less complicated than wrapping your head around the way a library wants to be extended and finding a way to start.

```php
// create the HTML Element for the original image
$baseImage = $this->baseImageRenderer->render($inline, $htmlRenderer);

// Provide modern browser lazy loading
$baseImage->setAttribute('loading', 'lazy');
// Set the data-src to the src that respects 'allow_unsafe_links' config
$baseImage->setAttribute('data-src', $baseImage->getAttribute('src'));
// Empty the original src
$baseImage->setAttribute('src', ''); 

return $baseImage;

``` 

I just added a few customizations that you can look up in the [documentation](https://github.com/simonvomeyser/commonmark-ext-lazy-image/blob/master/readme.md#options) of the package I created. 

To add these config keys you just read from it. 

```php
// The class that should be added
$htmlClass = $this->environment->getConfig('lazy_image/html_class', '');
```

The resulting (code)[https://github.com/simonvomeyser/commonmark-ext-lazy-image/blob/master/src/LazyImageRenderer.php] of the renderer should be pretty understandable now.

## Closing

Extending and tailoring the library to your needs is fairly straightforward once you got your feet off the ground. 

I found an approach to not only tag on things but to alter the behaviour of the core with the lazy image extension.

I hope this little exploration helps someone out there trying to extend Laravel's and therefore the `commonmark` package's functionality! 
 

