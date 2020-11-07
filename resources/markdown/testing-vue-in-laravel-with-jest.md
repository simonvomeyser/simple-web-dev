---
title: Testing Vue in Laravel with Jest - let's make it a little more easy
release_date: Today
slug: vue-testing-in-laravel
excerpt: >-

    Laravel offers an awesome testing environment for php, but if use Vue.js for much of your frontend, you most likely have big blindspot if you don't test that too.
    
    I try to ease the initial setup of testing Vue components in a dafault Laravel 6-8 Application.
tags:
  - Frontend
  - Dev Ops
  - Testing
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
---

Okay, let's admit it: Testing Laravel itself is an outright joy, but setting up tests for Vue.js components in your frontend is still quite a fight. Laravel can't provide an out-of-the-box solution, so you need to Google-Dive and assemble your own Frankenstein's Assertion Webpack Babel Monster. 

JavaScript and NPM packages change all the time, so most blogposts and tutorials are likely out of date (like this one, I greet you, future person 👋).

I still hope to help with my "currently working 2020 solution" here and will show you a little package making setting everything up a cinch. 

## Why JEST

- Dont take to long for the intro
- Say that it is for non SPAs
- Most tutorials are like "add this I don't know why"

Javascript libraries and solutions are changing all the time and its quite annoying. Broken examples from docs and tutorials are not hard to find and requires to search around for a working solution. Be aware of dates and versions when reading JS tutorials(like this one). I’m writing this tutorial to help others get through the task of setting up 

For a long time the default sexy Laravel stack included Vue.js as a frontend framework and that's awesome. Both technologies have a nice, clean approach to modern web application development and play nice with each other. While nowadays new alternatives like Livewire(**tod link**) emerge, or you could of course use the power of React, the pairing between Vue and Laravel was something that felt... just meant to be. 💕

**todo marryage foto of laravel and vue** 

While the communication of both should be discussed at another place, I want to talk about something that bugged me for a long time: As approachable as testing with Laravel was made, testing my frontend code was hard

The result is always the same: 

> If it's hard to write tests, nobody writes them

In most of my projects this meant even, that writing frontend tests was put off until later... and that's in an app where a lot of logic happens in the frontend. The customer does not care, if your well tested backend does return the right data, if your vue components break and look like you implemented a Nickleback record.

For this reason I want to talk a little about the things I had to fight with and already want to issue a warning:

> Start testing your frontend as early as possible

# Setting up testing, and why jest?

There are essentially two test runners that are recommended by the **toodo link docs** Mocha and Jest. Also working in React project I personally like Jest a lot better because it includes more things out of the box... and that always was one less thing for me to worry about.

It also was really hard for me to just get up and running with mocha and mocha webpack. In theory you could just use your existing Webpack configuration, but in practice this turned out to be configuration nightmare between laravel mix and mocha. Smarter people as me have made it work though (add link **todo**)

- how to set up jest and make it work
- First roadblock: Polyfills, rendering
- Second roadblock: Plugins
- Third roadbloack: Global functions
- fourth roadbloack: 
- fiths roadbloack: event emitters

summary, test as early as possible




