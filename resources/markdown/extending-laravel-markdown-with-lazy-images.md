---
title: Using Laravel's Markdown parser for a blog - and adding lazy images
release_date: Today
slug: extending-laravel-markdown-with-lazy-images
excerpt: >-
    I found out Laravel 6.x already ships with a pretty powerful package for parsing Markdown, and it can be extended and customized.
    
    After a few headaches I was able to configure it to my liking for this blog, and even create an extension that adds lazy images. 

tags: 
    - Backend
    - Tutorial
    - Laravel
header_image: https://res.cloudinary.com/simonvomeyser/image/upload/v1595353159/extending-laravel-markdown/Header_1.png
list_image: https://res.cloudinary.com/simonvomeyser/image/upload/v1595353159/extending-laravel-markdown/Header_1.png
---

Laravel makes use of a lot of powerful third party libraries and assembles them into a badass unit like Captain America does with the Avengers. 

I found out that a powerful library for Markdown parsing called [commonmark](https://github.com/thephpleague/commonmark) is already part of the team. I wanted use it during the relaunch of this blog because my posts are written in Markdown.

<sidenote heading="Only in Laravel 6 or higher">

The Markdown parser in Laravel 5.x was called [Parsedown](https://github.com/erusev/parsedown) and replaced in 6.x, since the new package offers more [security](https://github.com/laravel/framework/pull/30982)

The stuff in here will not work with an old Laravel Version, you could simply [install commonmark](https://github.com/thephpleague/commonmark/#-installation--basic-usage) yourself though.

</sidenote>

In this post I will explain how I was confused, then happy ...and then customized the library and implemented a [custom extension](https://github.com/simonvomeyser/commonmark-ext-lazy-image/) for lazy loaded images.

I really needed this extension because I tend to use way too many childish GIFs.

![A really childish gif of Monster Inc](https://res.cloudinary.com/simonvomeyser/image/upload/v1595350001/extending-laravel-markdown/childish.gif)

## Using the core library

By the time of writing, Laravel 6.x uses its internal Markdown parser for one purpose only: To make [Markdown Mailables](https://laravel.com/docs/7.x/mail#markdown-mailables) possible. 

These Mailables are a weird but wonderful mix of Blade and Markdown syntax.

![A cute image of a deformed but perfect rubik's cube being appreciated for it's weirdness](https://res.cloudinary.com/simonvomeyser/image/upload/v1595350001/extending-laravel-markdown/you-are-perfect.png)

All the rendering for this beautiful beasts is done by the class `\Illuminate\Mail\Markdown`, making heavy use of [sections and layouts](https://laravel.com/docs/7.x/blade#extending-a-layout). 

Hidden inside of these blade files there are direct calls to the one function that is important to us in this context:

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

Now that's pretty easy 😍 - but we are bound to the configuration Laravel dictates, so let's not stop here.
 
## Okay, how to configure it?

The `\Illuminate\Mail\Markdown` class is specialized in rendering mails for Laravel, so why toy with it. Let's configure the underlying library on our own!

<sidenote heading="Directly using a core library">

The Markdown rendering class is not bound to the service container or hidden behind an interface. For Laravel there is no sense in offering a sophisticated abstraction if the functionality is only used in one place.

For us in relying on the concrete library this means our code might break if the Laravel core team decides to switch the underlying markdown library. 

For now this is the most approachable solution though and it's unlikely that the library will change soon, but be wary of for this.

![Someone being not so smart and welding next to a gas tank](https://res.cloudinary.com/simonvomeyser/image/upload/v1595439948/extending-laravel-markdown/what-could-possibly-go-wrong.jpg)

</sidenote>

Laravel customizes the [league/commonmark](https://github.com/thephpleague/commonmark) package something like this:

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;

$environment = Environment::createCommonMarkEnvironment();

$environment->addExtension(new TableExtension);
$converter = new CommonMarkConverter([
    'allow_unsafe_links' => false,
], $environment);

$html = $converter->convertToHtml('The **Markdown** email');

```

You can already see things that are happening here:

- Adding a table Extension to provide the table component described in the [docs](https://laravel.com/docs/7.x/mail)
- Defaulting to not allow unsafe links, a precaution to prevent potential exploits

If you set up your converter like this, you can do [many more customizations](https://commonmark.thephpleague.com/1.4/customization/overview/) without even really diving into depth.
 
 I for example added the package's native [External Link Extension](https://commonmark.thephpleague.com/1.4/extensions/external-links/) to have links open in new windows.
 
```php
//...
$environment->addExtension(new ExternalLinkExtension());
$converter = new CommonMarkConverter([
    'external_link' => [
        'open_in_new_window' => true,
    ],
//...
```


Hm, but what can you do when there is not extension available for the functionality you want?

## Now extend it!

I wanted to add lazy images to my posts since it is a [performance best practice](https://developers.google.com/search/docs/guides/lazy-loading) - but I did not find an extension for this.

When you are only looking for lazy images you can [download my extension](https://github.com/simonvomeyser/commonmark-ext-lazy-image/), if you want to see how I did it and maybe want to create your own extension keep on reading!

### Into the depth

If you are used coding in Laravel the `League\CommonMark` library feels a bit *old school*. The setup and the configuration confused me already.
 
I don't mean to make a derogatory comment here though - the library is insanely flexible the authors did awesome work. You can alter almost everything and even access the generated AST before it is rendered to HTML. 

<sidenote heading="WTF is a AST?">

That's short for Abstract Syntax Tree - something that confused me multiple times since I never was smart enough for the [formal definition](https://en.wikipedia.org/wiki/Abstract_syntax_tree)

In this case just think of it as a data structure representing the markdown file: That could for example be an array for each line and in there a nested array for each word.

This is not *exactly* how the library does it, there are a lot of custom objects involved, but you hopefully get the idea.

</sidenote>

So before writing anything, we need to talk a little about the concepts:
 
The library thinks in *parsers* and *renderes*. Parsing means "recognizing a pattern in markdown and adding it to the things that should be rendered". Rendering happens after all the parsing is complete and is the actual transformation of the data into an HTML string.

It gets even a little more confusing since the library distinguishes between the handling of *blocks* (like paragraphs) and *inlines* (like images, bold text) . Both types have respective *parsers* and *renderes*. 

![Grandma really overwhelmed by the php library](https://res.cloudinary.com/simonvomeyser/image/upload/v1595350001/extending-laravel-markdown/what-grandma.png)

I will not go more into depth here because in many cases you will not write your own versions of these.

<sidenote heading="Help, I want to write parsers and renderes">

If you need to really parse new syntax like transforming Twitter handles into links to the person's profile, there is a good [tutorial](https://commonmark.thephpleague.com/1.3/customization/inline-parsing/#inline-parser-examples) for it. 

This new parser searches for Twitter handles and adds a Link object to the profile URL to the in the AST. This object is later rendered by the native link renderer.

I cannot go further into this, but I hope this helps with the initial understanding. 

![Morpheus of the Matrix telling you, that you are on your own now. Poor you.](https://res.cloudinary.com/simonvomeyser/image/upload/v1595441262/extending-laravel-markdown/on-your-own-now.jpg)

</sidenote>


### Creating our Extension

Most of the core extensions work in more understandable way: They don't add parsers or renderers, they just change the already created data by adding a few things. If that's your jam maybe look at the source of the [External Link Extension](https://github.com/thephpleague/commonmark/blob/latest/src/Extension/ExternalLink/ExternalLinkProcessor.php), it's quite easy to understand.

Since I wanted my lazy image extension to not only add something like an `loading="lazy"` attribute but also to support lazy loading libraries I had one main problem:

The native work like checking for a secure source of an image is implemented in a renderer, not in a parser. I therefore needed to alter the output *after* rendering - to then optionally remove the `src` and add that in a `data-` attribute.

In first naive approach was to simply copy the whole original renderer, adding my own functionality and making the core or the package use my class instead of the original:

```php
//...

$environment->addInlineRenderer( 
    'League\CommonMark\Inline\Element\Image', 
    new ImageRendererReplacement(),
    42 // Priority, original is 0, we just need to go higher
);
``` 

That works but is no way to live your life. The replaced `ImageRenderer` might change in the future, receive security updates and people using our extension would not benefit from those. 

I needed the processing inside the native image renderer to run before my functionality. Extending was not an option because the classes are final - something I saw many [discussions](https://twitter.com/taylorotwell/status/1237068965177892864) about, but it was the first time it affected me.

![A lot of twitter noise and discussions about the final keyword](https://res.cloudinary.com/simonvomeyser/image/upload/v1595350000/extending-laravel-markdown/final-discussion.png)

I still have no final (eheh) opinion about this. There was already a discussion in the [issues](https://github.com/thephpleague/commonmark/issues/379) so I will not rehash it here. I get the argument and respect the package author's decision.

I ended up not subclassing but calling the original renderer and modifying the output in a composition over inheritance approach. Put simply: My own class just uses the core image renderer, gets it's output and changes that output. 

Then you just tell the library itself to use your renderer instead of the original one, like in the first naive example.

The actual *programming* that needed to be done after that was quite simple, but that is the whole reason I wanted to write this post: Usually the implementation of a feature is way less complicated than finding a way to start.

```php
//...
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

I just added a few customization options that you can look up in the [documentation](https://github.com/simonvomeyser/commonmark-ext-lazy-image/blob/master/readme.md#options) of the package I created. 

Working with these options is really straightforward: 

```php
//...
$htmlClass = $this->environment->getConfig('lazy_image/html_class', '');

if ($htmlClass) {
    $baseImage->setAttribute('class', $htmlClass);
}
//...
```

The resulting [code](https://github.com/simonvomeyser/commonmark-ext-lazy-image/blob/master/src/LazyImageRenderer.php) of the renderer should be pretty understandable now.

## Closing

Extending and tailoring Laravel's Markdown library to your needs is fairly straightforward once you wrap your head around the concepts. 

I found an approach to not only glue some things to the existing output but to alter the behavior of the package core with my lazy image extension.

I hope this little exploration helps someone out there trying to extend Laravel's and therefore the `commonmark` package's functionality! 
 

