---
title: Use the Laravel Scheduler without access to cronjobs
release_date: March 2020
slug: the-laravel-scheduler-without-cronjobs
excerpt: >-
  The Laravel Scheduler is an awesome tool since it greatly simplifies the usage
  of confusing cron job definitions I am simply not smart enough for.

  Learn to use this feature without access to your servers cron jobs on cheap
  hosters
tags:
  - Backend
  - Dev Ops
  - Laravel
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611629/laravel-scheduler/laravel-scheduler-list-header-image.jpg
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611629/laravel-scheduler/laravel-scheduler-list-header-image.jpg
---

The Laravel Scheduler is an awesome tool since it greatly simplifies the usage of confusing cron job definitions I always seem to be too stupid for.

I like the fact that it (like many things in the Laravel ecosystem) offers great readability 🙂

<figure class="wp-block-image">
  <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1552377554/laravel-scheduler/dodge-laravel-scheduler.png" alt="" class="wp-image-294">
</figure>

The setup also seems to be really simple, see [the docs](https://laravel.com/docs/5.7/scheduling#introduction)

> When using the scheduler, you only need to add the following Cron entry to your server

Okay.. damn.

# I have no direct access to my server 🥺

I personally still have some projects where I have no root access and either can't setup cronjobs at all.. or have a (usually but ugly) interface to set up cronjobs on only a route to visit periodically, maybe not even every minute.

Some customers still want to use cheap hosting.. and that should be okay ¯_(ツ)_/¯

I found a pretty approachable solution to still use the power of Laravel schedules... this is what I want to talk about in this short article.

# Setup a GET route for the scheduler

The first thing you should do is to setup a "/scheduler" route that will serve as an alternative to the command `php artisan schedule:run`

```php
Route::get('/scheduler', function() {
    Artisan::call('schedule:run');
});
```

This makes the command accessible via a simple GET request. Hooray, we are almost done already

If you are worried that everybody could access that route... it's pretty straightforward to protect it with an API key like so

<x-code>
    Route::get('/scheduler/{key}', function() {
    if ($key === 12345) {
    Artisan::call('schedule:run');
    }
    });
</x-code>

Of course, you could move that key to your .env file ... or even use a full-blown auth flow.

# Example: Setup on all-inkl.com

Some legacy systems of mine are hosted on all-inkl.com so I thought I would use them to show how to setup a cron job via their interface.

<x-video code="CcO4Q53Mm_U">
</x-video>

Every hoster that offers some kind of cron jobs but no shh/command line access in their plan should have a similar interface hidden somewhere.

But what about when you have no access to cron jobs at all?

## No cronjobs at all with your hoster? Still not a problem 👍

You could

<g class="gr_ gr_9 gr-alert gr_gramm gr_inline_cards gr_run_anim Grammar multiReplace" id="9" data-gr-id="9">
    of</g>

course periodically hit that route by yourself. But that kind of defeats the purpose right? Luckily there are so many products that offer "cronjobs as a service"

Some of them are listed at [cronjobservices.com](https://www.cronjobservices.com/), they did good work of comparing some of them. But hey, other options are just a googly [search](https://www.google.de/search?q=cronjob+as+a+service) away 🙂

<figure class="wp-block-image">
  <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1553756347/laravel-scheduler/Screenshot_2019-03-28_at_07.56.20.png" alt="">
  <figcaption>Screenshot from <a href="https://www.cronjobservices.com/">https://www.cronjobservices.com/</a></figcaption>
</figure>

If you don't want to or can't pay for a service you have to keep in mind that most of the free options won't allow calling your`/scheduler` route every minute. An option could be to set up your Laravel schedules according to limitations of the service you use.

Example: You use a free service that only allows for a cronjob every 20 minutes: You can still plan things like sending reminder emails for every 20, 40, 60 Minutes and so on, they will be sent.

If you, on the other hand, set up something that should happen every 5 minutes, it will still only happen all 20 minutes. Even worse, something that is not divisible without remainder will make your brain melt. You did set up a task that should run every 7 minutes but your free cron job service hits the route only every 60 minutes? The least common multiple is 420, so will only run every 7 hours 🤯

I hope you got the idea if not send me your questions... or save yourself the math and pay for a cronjob service to hit the route every minute as suggested. All services are quite affordable.

Hey, we are done 🙂

## Bonus: Testing dat route tho

Just a little bonus: If you want to test if your scheduler command gets run when you hit the route it is really straightforward

<x-code>
    /**</x-code>

```
`* @test`

- @return void */ public function calling_the_scheduler_route_runs_the_artisan_command() { Artisan::shouldReceive('call') ->once() ->with('schedule:run');

`$this->get('/scheduler')->assertStatus(200); }`



Testing that certain commands are run is really easy. With this, you are all set and also have a test in place that
"communicates" the importance of that route. If someone changes it, the tests will fail.

Hooray! Happy hacking and see you soon. 🙂
```
