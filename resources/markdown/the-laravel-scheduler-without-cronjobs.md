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
  https://res.cloudinary.com/simonvomeyser/image/upload/v1591085383/laravel-scheduler/Blog_Header.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1591085383/laravel-scheduler/Blog_Header.png
---

The Laravel Scheduler is an awesome tool since it greatly simplifies the usage of confusing cron job definitions I am not smart enough for.

But in all seriousness: I like the fact that moves schedules in the project's version control, and it also offers great readability 🙂

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1552377554/laravel-scheduler/dodge-laravel-scheduler.png)

The setup seems to be really simple, see [the docs](https://laravel.com/docs/5.7/scheduling#introduction)

> When using the scheduler, you only need to add the following Cron entry to your server

Hm, what's a "Cron"? (looks it up) Nooo! I cannot do that since I am using a cheap hosting service!

## I have no direct access to my server 🥺

I personally still have some projects where I have no root access and either can't setup cron jobs at all ... or have a (usually light speed ugly) interface to set up cron jobs on only a route to visit periodically, maybe not even every minute.

Some customers still want to use cheap hosting, and that should be okay 🤷‍♂️

I lately found a pretty approachable solution to this!

## Setup a GET route for the scheduler

The first and central thing you should do is to set up a `/scheduler` route that will serve as an alternative to running the command `php artisan schedule:run` from the command-line.

```php
Route::get('/scheduler', function() {
    Artisan::call('schedule:run');
});
```

This makes the command accessible via a simple GET request. Hooray, we are almost done already! Most cheap hosters offer some way of periodically visit certain URLs, so why not set what up with your hoster of choice?

Just keep in mind that some of them won't allow calling your`/scheduler` route every minute, some even do it at more or less random intervals.

The problem is that Laravel Scheduler works in a special way: Say you schedule things for every 15 minutes, if your hoster never calls the route *exactly* at the full hour or fifteen, thirty or forty-five minutes after a full hour, your schedule might *never* be called. 

You could resort to minutely or daily scheduled tasks, but if there are many of them this might cause the PHP process to time out since it is technically not run on the commandline. It's bound to the execution time and memory limit.

Don't despair if your hoster does not offer the "one minute cron job": There is another solution!
 
## Using external services 

Since visiting the new route yourself every minute would make you a modern-day Sisyphus - Why not use a product that offers "cron jobs as a service"?

CaaS, I even like how that sounds. Almost like the Dutch word for cheese. Hmmm cheese! 🧀

Some of them are listed at [cronjobservices.com](https://www.cronjobservices.com/), they did good work of comparing some of them. But hey, other options are just a googly [search](https://www.google.de/search?q=cronjob+as+a+service) away 🙂

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1553756347/laravel-scheduler/Screenshot_2019-03-28_at_07.56.20.png) Screenshot from <https://www.cronjobservices.com/>

I personally tried [cron-job.org](https://cron-job.org) and I am really happy with them, it is free and allows cron jobs to run every minute.

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

Testing that certain commands are run is that easy. Now you have a test in place that "communicates" the importance of that route. 

Hooray, I hope this was helpful! Happy hacking and see you soon. 🙂
