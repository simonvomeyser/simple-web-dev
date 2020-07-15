---
title: Extending Laravel's commonmark Markdown - adding lazy images
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

Parts of the Symphony Framework provide solid low level functionality and testing is entrusted to the awesome folks at PHPUnit.

I also read some articles about the power of the Laravel Markdown Renderer [here](https://medium.com/@DarkGhostHunter/laravel-there-is-a-markdown-parser-and-you-dont-know-it-5f523e22121e)  which recently switched to the Commonmark Library from Parsedown https://github.com/laravel/framework/pull/30982

???
https://laracasts.com/discuss/channels/laravel/best-way-to-render-markdown-in-views

While I was implementing simple-web.dev I wanted to use Laravel to have full control about the implementation - and I definitely wanted to write the posts in Markdown to keep them in git.

I will go over a few customizations I did to render my blog posts by using just the Commonmark implementation Laravel already provides - especially adding lazy loaded images to my posts, since I tend to use too many childish GIFs.

??? Add childish gif

## Using Laravel's Commonmark implementation

```
\Illuminate\Mail\Markdown::parse('# Hello');

or even render text? then youll have to initialize
```
 
## Costomize it

## Extend it
