---
title: Testing your Vue.js in Laravel - common gotchas and why to start as early as possible
release_date: Today
slug: vue-testing-in-laravel
excerpt: >-

    Laravel offers an awesome testing environment, but if you are like me and use Vue.js for much of the frontend, you most likely have big blindspot on your testing map
    
    I want to talk about a few roadblocks, bruises and broken legs I experienced while adding vue testing layers to applications.
tags:
  - Frontend
  - Dev Ops
  - Testing
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
---

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




