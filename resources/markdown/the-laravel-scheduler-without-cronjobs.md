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

I like the fact that it (like many things Laravel) offers great readability 🙂

<figure class="wp-block-image">
  <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1552377554/laravel-scheduler/dodge-laravel-scheduler.png" alt="" class="wp-image-294">
</figure>

The setup also seems to be really simple, see [the docs](https://laravel.com/docs/5.7/scheduling#introduction)

> When using the scheduler, you only need to add the following Cron entry to your server

Nooo! What's a "Cron"? Nooo! I can not do that since I am using a cheap hosting service like bluehost or hostegater!

## I have no direct access to my server 🥺

I personally still have some projects where I have no root access and either can't setup cronjobs at all.. or have a (usually butt ugly) interface to set up cronjobs on only a route to visit periodically, maybe not even every minute.

Some customers still want to use cheap hosting.. and that should be okay ¯_(ツ)_/¯

I found a pretty approachable solution to still use the power of the Laravel Scheduler!

## Setup a GET route for the scheduler

The first and central thing you should do is to setup a `/scheduler` route that will serve as an alternative to running the command `php artisan schedule:run` from the commandline.

```php
Route::get('/scheduler', function() {
    Artisan::call('schedule:run');
});
```

This makes the command accessible via a simple GET request. Hooray, we are almost done already! Most cheap hosters offer some way of periodically visit certain URLs, so why not set what up with your hoster of choice?

Just keep in mind that some of them won't allow calling your`/scheduler` route every minute. An option could be to set up your Laravel schedules according to limitations of the service you use: If your hoster allows a cronjob to visit a route every 20 minutes you can still plan things in 20, 40, 60 Minute increments.

If you, on the other hand, set up something that should happen every 5 minutes but only can hit the route all 20 minutes, you are asking for headache! Even worse, some combination that is not divisible without remainder will make your brain melt. You did set up a task that should run every 7 minutes but you hit the route only every 60 minutes? The least common multiple is 420, so it will only run every 7 hours 🤯

## No cronjobs at all with your hoster? Still no problem!

Since visiting the new route yourself every minute would make you a modern day Sisyphus - Why not use a product that offers "cronjobs as a service"?

CaaS, I even like how that sounds. Almost like the dutch word for cheese. Hmmm cheeese. 🧀

Some of them are listed at [cronjobservices.com](https://www.cronjobservices.com/), they did good work of comparing some of them. But hey, other options are just a googly [search](https://www.google.de/search?q=cronjob+as+a+service) away 🙂

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1553756347/laravel-scheduler/Screenshot_2019-03-28_at_07.56.20.png) Screenshot from <https://www.cronjobservices.com/>

I personally tried <https://cron-job.org> and I am really happy with them, it is free and allows cronjobs to run every minute.

Hey, that's all I wanted to say already 🙂

## Bonus: Testing dat route tho

Just a little bonus: If you want to test if your scheduler command gets run when you hit the route it is really straightforward

```php
/** @test */ 
public function the_scheduler_route_works() {
  Artisan::shouldReceive('call')
    ->once()
    ->with('schedule:run');

  $this->get('/scheduler')->assertStatus(200); 
}
```

Testing that certain commands are run is that easy. Now you have a test in place that "communicates" the importance of that route. If someone changes it, the tests will fail.

Hooray! Happy hacking and see you soon. 🙂
