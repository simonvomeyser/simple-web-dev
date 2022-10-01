---
title: How to use env variables with Laravel Envoy scripts
release_date: 16.09.2022
slug: use-env-variables-in-laravel-envoy
excerpt: >-

    Laravel Envoy provides a nice alternative for projects that don't need or can't have a push to deploy setup.

    I found out that you can use environment-variables quite easily inside tasks.

tags:
  - Laravel
  - Dev Ops
  - Deployment
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1663329894/laravel-envoy/laravel-enovy.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1663329894/laravel-envoy/laravel-enovy.png
---
<small>Tested on Laravel `9.3` and Laravel Envoy `2.8`</small>

I use Laravel Envoy in some projects (including in this [open sourced blog](https://github.com/simonvomeyser/simple-web-dev)) to deploy directly from the commandline. While some of these projects maybe should use ci-pipeline (and surely will) I also like the simplicity of Envoy from time to time. 

Just commit locally, run your tests and deploy all in one go.

I recently was happy to notice, that you can even use all Laravel helper functions inside scripts – but sadly, the `env()` command was not working

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

You now are able to create a deployment script that uses variables from your `.env` file via the `env()` helper!

Keep in mind, that inside the `@task ... @endtask` block we have to use Blade-style, when defining the `@servers` we use pure PHP:

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

Thanks to [Amit](https://twitter.com/amit_merchant) who wrote [an article](https://www.amitmerchant.com/how-to-use-env-in-laravel-envoy/) about this that led my on the right track, but the solution was not completely working for me.

So long! 
Simon
