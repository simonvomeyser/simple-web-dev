---
title: How and why to use Spatie's response cache with Statamic 
release_date: today
slug: use-spatie-response-cache-with-statamic
excerpt: >-
    Spatie's response cache package speeds up your page quite considerably.
    
    This is fine for static pages, but I found a quick way on how to use the library with the awesome Laravel CMS Statamic
tags:
  - Backend
  - Laravel
  - Statamic
  - CMS
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
---

I think [Spatie's response cache package](https://github.com/spatie/laravel-responsecache) should simply be used on all static Laravel pages. Not only does it improve your user's experience, it also takes load of your server and makes Google like you more. 

When using this package with dynamic content, there is this dreaded, scary thing called *cache invalidation*. The saying goes:

> Only 2 things in development are hard: Naming things, cache invalidation and off-by-one errors

Luckily I found a really simple way of using it with my favorite CMS [Statamic](https://statamic.com/) (❤️) . You don't need to manually keep track of changes made.

## Enough Talk

To keep this short for change, let me get right down to it:

Of course, you need to have an working version of [Statamic installed](https://statamic.dev/installation). In your project, also install the response cache package by running

```bash 
composer require spatie/laravel-responsecache
```

After that, you need to add the middleware to your web group to apply the cache to all your routes. See [the docs](https://github.com/spatie/laravel-responsecache) for more information.

```php
// app/Http/Kernel.php

...

protected $middlewareGroups = [
   'web' => [
       ...
       \Spatie\ResponseCache\Middlewares\CacheResponse::class,
   ],

```

Now here is the kicker: To clear the cache everytime something is updated in the Statamic backend, you need to create a new [Even Subscriber](https://laravel.com/docs/master/events#event-subscribers) that clears the cache like so. You may place the file wherever you want. 

```php
// app/Subscribers/ResponseCacheStatamicSubscriber

<?php


namespace App\Subscribers;

use Spatie\ResponseCache\Facades\ResponseCache;
use Statamic\Events\Concerns\ListensForContentEvents;

class ResponseCacheBuster
{
    use ListensForContentEvents;

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        foreach ($this->events as $event) {
            $events->listen($event, self::class.'@clear');
        }
    }

    /**
     * Commit changes.
     *
     * @param mixed $event
     */
    public function clear()
    {
        if (config('responsecache.enabled')) {
            ResponseCache::clear();
        }
    }

}


```

The whole *magic* here is happening in the trait `Statamic\Events\Concerns\ListensForContentEvents` where the Statamic team keeps all the Events neat and tidy you need to listen for.

Then simply add this subscriber to the `EventServiceProvider` and you are already done!

go on here



## During Development

Just a quick note because I tend to forget this way to often: Remember to add a line to your local `.env` file that you do not want to use the response cache there. 

```
# .env
...
RESPONSE_CACHE_ENABLED=false
...
```

## Why though?

You may ask "why the hassle, Statamic already comes with a pretty good cache". While this might be true and I am by no means an expert in the awesome work the Statamic Team is doing I found Spatie's response cache making my pages much faster.

Especially on landing pages that iterate through a lot of collections I found a quite remarkable speed improvement with this approach. Let me know your experiences, maybe on Twitter <3

So long
Simon


























