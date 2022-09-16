---
title: How to use env variables in Laravel Envoy
release_date: now
slug: use-env-variables-in-laravel-envoy
excerpt: >-

    Laravel Envoy provides a nice alternative for projects that don't need or can have a push to deploy setup.

    I found out that you can use environment-variables quite easily inside tasks.

tags:
  - Laravel
  - Dev Ops
  - Deployment
header_image: >-
  https://via.placeholder.com/1024x768
list_image: >-
  https://via.placeholder.com/1024x768
---
<small>Tested on Laravel `9.3` and Laravel Envoy `2.8`</small>

I use Laravel Envoy in some projects (including currently in this [open sourced blog](https://github.com/simonvomeyser/simple-web-dev)) to deploy projects directly from the commandline. While some of these projects should use ci-pipeline (and maybe will) I also like the simplicity of changing something, running the test locally and then deploying it – all on my machine. 

I recently was happy to notice, that you can use all laravel helper functions inside Laravel Envoy scripts – but sadly, the `env()` command was not working

<div v-pre>

```php
// ...

// this outputs "HELLO WORLD" on the server, that's cool! 🙂
@task('deploy', ['on' => 'web'])
    echo "{{str('hello')->upper()}}";
@endtask

// this outputs nothing 😢
@task('deploy', ['on' => 'web'])
    echo "{{env('APP_URL')}}";
@endtask

```

</div>

I guess that is the case because Laravel Envoy is set to be more of a framework-agnostic SSH solution for PHP and the `LoadEnvironmentVariables` class is deeply wired into the kernel of a Laravel application.

Luckily, you can load the `.env` content in the `@setup` method like described in the docs of underlying library [phpdotenv](https://github.com/vlucas/phpdotenv)

<div v-pre>

```php
@setup
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
@endsetup

// ...
```

</div>

You now are able to create a deploy script that uses Variables from your `.env` file via the `env()` helper!

Keep in mind, that inside the `@task ... @endtask` block we have to use Blade-style syntax to use variables, when defining the `@servers` we use pure PHP:

<div v-pre>

```php
@setup
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
@endsetup

@servers(['web' => [env('DEPLOY_USER') . '@' . env('DEPLOY_HOST')]])

@task('deploy', ['on' => 'web'])
    cd {{ env('DEPLOY_LOCATION') }}
    git pull
    npm install
    npm run prod
    compsoser install --no-dev
    php artisan cache:clear
    php artisan config:clear
@endtask
```

</div>

We are now able to hide away either sensitive or irrelevant information and put it into our `.env` 🎉

Thanks to [Amit](https://twitter.com/amit_merchant) who wrote [an article](https://www.amitmerchant.com/how-to-use-env-in-laravel-envoy/) about this that led my on the right track, but the solution was not complete for me.

So long! 
Simon
