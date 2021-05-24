---
title: How to use Spatie's response cache with Statamic 
release_date: 30.05.2021
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
  https://res.cloudinary.com/simonvomeyser/image/upload/v1621870712/response-cache-statamic/header.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1621870712/response-cache-statamic/header.png
---

I think [Spatie's response cache package](https://github.com/spatie/laravel-responsecache) should simply be used on all Laravel pages. Not only does it improve your user's experience, it also takes load of your server and makes Google like you more. 

When using this package with dynamic content, like with my favorite CMS [Statamic](https://statamic.com/) (❤️), there is this dreaded, scary thing called *cache invalidation*. The saying goes:

> Only 2 things in development are hard: <br> Naming things, cache invalidation and off-by-one errors

Luckily I found a really simple way of using it. You don't need to manually keep track of changes made.

## Enough Talk

To keep this short for change, let me get right down to it:

Of course, you need to have an working version of [Statamic installed](https://statamic.dev/installation). In your project, also install the [response cache package](https://github.com/spatie/laravel-responsecache#installation) by running

```bash 
composer require spatie/laravel-responsecache
```

After that, you need to add the middleware to your web group to apply the cache to all your routes. See [the docs](https://github.com/spatie/laravel-responsecache) for more information and options.

```php
// app/Http/Kernel.php

...

protected $middlewareGroups = [
   'web' => [
       ...
       \Spatie\ResponseCache\Middlewares\CacheResponse::class,
   ],

```

Now here is the kicker: To clear the cache everytime something is updated in the Statamic backend, you need to create a new [Even Subscriber](https://laravel.com/docs/master/events#event-subscribers) that clears the cache after that. Create and place the following file wherever you want:

```php
// app/Subscribers/ResponseCacheStatamicSubscriber

<?php

namespace App\Subscribers;

use Spatie\ResponseCache\Facades\ResponseCache;
use Statamic\Events\Concerns\ListensForContentEvents;

class ResponseCacheStatamicSubscriber
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

```php
//App\Providers\AppServiceProvider


use App\Subscribers\ResponseCacheBuster;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Statamic\Git\Subscriber;

class EventServiceProvider extends ServiceProvider
{
    // ...

    protected $subscribe = [
        ResponseCacheStatamicSubscriber::class
    ];

    // ...
}

```

## During Development

Just a quick note because I tend to forget this way to often: Remember to add a line to your local `.env` file that you do not want to use the response cache there. 

```
# .env
...
RESPONSE_CACHE_ENABLED=false
...
```

## Why though?

You may ask "why the hassle, Statamic already comes with a pretty good cache". You are right, and in essence this approach should yield quite similar results like [Application Driver](https://statamic.dev/static-caching#application-driver) approach of the build in statamic cache. 

I found a little speed improvement in this approach though, but this could be because I mostly create Statamic sites with Blade views instead of using Antlers, the Statamic templating engine.

If you use this or not, I just wanted to share what I learned 👍

Best!
Simon


























