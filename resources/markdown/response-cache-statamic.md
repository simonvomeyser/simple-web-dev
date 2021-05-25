---
title: How to use Spatie's response cache with Statamic 
release_date: today
slug: use-spatie-response-cache-with-statamic
excerpt: >-
    Spatie's response cache package speeds up your page quite considerably.
    
    This is fine for static pages, but I found a quick way how to use the library with the awesome Laravel CMS Statamic
tags:
  - Backend
  - Laravel
  - Statamic
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1621870712/response-cache-statamic/header.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1621870712/response-cache-statamic/header.png
---

I think [Spatie's response cache package](https://github.com/spatie/laravel-responsecache) should be used on more pages. The speed improvement is impressive, and even on highly dynamic pages, data is read more often than it is written or changed - a lot of room for improvement.

On static pages, the package should be a real no-brainer. When using it with dynamic content, like with my favorite CMS [Statamic](https://statamic.com/) (❤️), there is this dreaded, scary thing called *cache invalidation*. When and how should we clear the cache when content changes? The saying goes:

> Only 2 things in development are hard: <br> Naming things, cache invalidation and off-by-one errors

Luckily I found a really simple way of integrating it!

## Enough Talk

To keep this post short for change, let me get right to it:

Of course, you need to have a working version of [Statamic installed](https://statamic.dev/installation). In your project, also install the [response cache package](https://github.com/spatie/laravel-responsecache#installation) by running

```bash 
composer require spatie/laravel-responsecache
```

After that, you need to add the middleware to your web group to apply the cache to all your (GET) routes. See [the docs](https://github.com/spatie/laravel-responsecache) for more information and options.

```php
// app/Http/Kernel.php

...

protected $middlewareGroups = [
   'web' => [
       ...
       \Spatie\ResponseCache\Middlewares\CacheResponse::class,
   ],

```

Now here is the kicker: To clear the cache everytime something is updated in the Statamic backend, you need to create a new [Event Subscriber](https://laravel.com/docs/master/events#event-subscribers) that clears the cache after a "something happened in Statamic" event. Create and place the following file wherever you want:

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

The whole *magic* here is happening in the trait `Statamic\Events\Concerns\ListensForContentEvents` where the Statamic team keeps all the Events neat and tidy for you need to listen for.

Then simply add this subscriber to the `EventServiceProvider` and you are already done! Your cache is cleared and rebuild on every update, but most users will get a lightning fast response 👍

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

You may ask "why the hassle, Statamic already comes with a pretty good cache". You are right, and in essence this approach should yield quite similar results like the [Application Driver](https://statamic.dev/static-caching#application-driver) approach of the build in Statamic cache. 

I found a little speed improvement using Spatie's library though, but this could be because I mostly create Statamic sites [with Blade](https://statamic.com/addons/silentz/blade) instead of using Antlers, the Statamic templating engine.

If you use this or not, I just wanted to share what I learned 🎉 

Best!
Simon


























