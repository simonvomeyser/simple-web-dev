---
title: You might not need an FTP client to deploy your website…
release_date: February 2020
slug: do-not-use-a-ftp-client
excerpt: >-
  For a long time I was hesitant to dive into alternatives and always used FTP clients for deployment.
  
  Recently I noticed there are a many small steps without immediately sailing rough seas on docker ships.
tags:
  - Backend
  - Dev Ops
header_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
list_image: >-
  https://res.cloudinary.com/simonvomeyser/image/upload/v1588611570/dont-use-ftp/dont-use-ftp-list-header-image.png
---

For a long time I was really hesitant to dive into the world of alternatives to FTP clients when I wanted to deploy, upload or update a web project.

<blockquote class="twitter-tweet" data-theme="light"><p lang="en" dir="ltr">&gt; Our deployment pipeline...?<br>*quickly closes FTP connection to live site*<br>&gt; ....yes, we have one.</p>&mdash; I Am Devloper (@iamdevloper) <a href="https://twitter.com/iamdevloper/status/1064532628664143872?ref_src=twsrc%5Etfw">November 19, 2018</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

A story from some time ago could have been as follows: I fired up _FileZilla_ and dragged and dropped a long overdue update for the live site over. Did I get all of them? Refresh the live page.. ouoh.. an Error

... the telephone rings a few seconds later. Client: "Why is our website down?!". Sweat, fear, drama, airplanes crashing in the background!

Better re-upload the whole project to be sure.

Remaining: 10000 files, estimate 2 hours. Ahhh.. better walk up and down the office and pull my hair until the upload is completed.

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1548395231/dont-use-ftp/dog.gif)

If this sounds at least a bit familiar you have seen the ugly side that comes with FTP Clients and their simplicity.

I always knew that there were much better ways to get our website up onto servers... but it all felt so overwhelming.

A virtual machine on the client's cheap hosting? No way! A Docker Container for each new deployment? What? Help!... A continuous integration pipeline? **You're a pipeline!**

While I nowadays use and love some of these tools, I discovered that there are also some really simple things you can do to greatly improve your ability to sleep at night when deploying a project.

> There are some small wins you can improve your deployment process with that are not crazy complicated!

<sidenote heading="Please use git!">

You should <strong>always</strong> use a version control system! If you don’t do it some of these tricks
won’t work.

If you think it is too complicated for your simple project chances are good you just need to familiarize
yourself more with git in general. The basics are really easy and highly beneficial.

Believe me, I am all and always for keeping things simple but in this case the benefits far ooutweighthe
costs. Just do it!

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1548395373/dont-use-ftp/justdoit.gif)

</sidenote>

## rsync and other command-line tools

To be honest I always shied away from these because it just seemed to much to remember. Most of them only partly work on windows and the setup looked like this to me:

```bash
xysync -ohno -wtf /usr/bin/danger --force --destroy production-site.com
```

And I was like “no way I am trying that, my computer will exterminate all humans if I execute that command”

![](https://res.cloudinary.com/simonvomeyser/image/upload/v1548577943/dont-use-ftp/200.gif)

To be a little less childish here: rsync in particular works great for doing exactly what it name sounds like: Syncing between two places, be it between two folders (e.g. for backup) or two machines (e.g. your dev machine and a server).

### What should I do?

Between two folders it is really easy to use rsync:

```bash
rsync -a my-files/ backup/
```

This will sync all files from `my-files` to `backup`. The parameter `-a` says it should include subfolders and preserve file properties

An example to download all files from a remote folder would be:

```bash
rsync -a ssh-username@domain.com:/www/htdocs/some-website/uploads ~/Desktop/uploads
```

When you now turn this around, you could simply sync your directory you develop your website in and only upload the changes, rsync does all this comparing work for you. Use this:

```bash
rsync -a ~/Desktop/my-website/ ssh-username@domain.com:/www/htdocs/my-webiste/
```

Of course there are lots of options how to overwrite, ignore some, show progress, test run before you nuke anything and so on. I found a [cool video](https://www.youtube.com/watch?v=qE77MbDnljA) that will help you get started 🙂

### Caveats

As I already said this is not as easy on Windows as it is on Mac or Linux. It will also feel quite hacky, and you might be nervous before hitting 'Enter'. 

Just save the command you will use regularly somewhere, so the probability of setting something on fire is a bit smaller.

<div id="git-ftp">

## Git-ftp

</div>

This [project](https://github.com/git-ftp/git-ftp) is a really elegant solution that actually still uses FTP under the hood. But instead of flipping open your FTP Client (and endangering everyone around you) it will only upload the files you changed after the last upload you did.

What a relieve already knowing that _exactly_ the files you changed will be uploaded! Old files will be deleted and each "push" only takes a few seconds. I was initially hesitant to use it because I did not understand one key thing:

> git-ftp does not really care what is on your server.

It just adds a file to your server where the hash of your last commit is stored. When you want to "push" it first looks for this hash in the text file, checks what has happened since then and only uploads the difference. No black magic there.

You can actually do the setup of a site with your FTP client of choice, make it work and only use git FTP from there for updates.

### What should I do?

The simplest way in an *existing* project to get going with git-ftp is:

[Install it](https://github.com/git-ftp/git-ftp/blob/master/INSTALL.md) and then add the config (These are stored in the file `.git/config` if you ever want to change them)

```bash
git config git-ftp.url "ftp://your-website.net:21/the_location/"
git config git-ftp.user "ftp-user"
git config git-ftp.password "secr3t"
```

And tell git-ftp to use the current state as a starting point only.

```bash
git ftp catchup
```

Then you work and work and work, (hopefully) commit a lot, push, merge and do all the git craziness we love and still don't understand fully.

When you want to “deploy” your site, just run the following command:

```bash
git ftp push
```

And voilà: Your changes should be online in no time.

There are a lot of [advanced options](https://github.com/git-ftp/git-ftp/blob/master/man/git-ftp.1.md) but these few lines of the code above have made my life a lot better already 🥰

When you have "fresh" project I usually set the project up with an FTP client but git-ftp also offers the `init` command for that. It actually does not matter that much because I think the most headaches coming from FTP are introduced during later updates and not the initial upload.

### Caveats

When you work in a team you need to communicate who does the deployments and make sure that not two persons are executing a git-ftp push at the same time.

I also ran into some issues with changing a site from production to live in another folder... but that was nothing a quick googly google search could not fix.

This project is awesome!

## git pull with ssh

Git is a wonderful tool. It already knows about all the things you changed and what the current state of your website _should_ be. Why not use that, even without something like git-ftp?

When your hoster offers the possibility to connect to your server via SSH you could just connect, move into the directory of your website and execute a `git pull` Easy right?

<embed-video code="vpz71ZSR4iQ"> </embed-video>

Of course it’s a little more complicated when you want to automate that:

- You will need a hosted _origin_ repository somewhere your server can reach and pull from. If your project is already on services like GitHub, GitLab or Bitbucket you are set, but if you don't push to a remote or your remote is only accessible from your companies VPN you'll have a hard time.

- Git has to be installed on the server. Test that with the command `git --version`. If it is not available you'll need to [install it](https://www.atlassian.com/git/tutorials/install-git) or ask your hoster to do that. On most hosters it should be installed already.

- As your local version, the server needs to *know* that your site is a git rep. You will have a problem when you try to transfer a project that was only locally managed by git before.

I would strongly advise to re-setup your site when you have started without git. Just run a `git clone` on the server and everything is setup for you.

You could also upload the hidden `.git` folder (maaaybe via FTP? 😱) and try your luck from there. You'll need to incorporate possible changes on the server, inconsistencies with your ignored files and so on. Maybe [git-ftp](#git-ftp) is a better solution, maybe you will have to do the work though since you likely don't want your production files to differ from their git counterparts in version control.

### Caveats

While the theory is quite simple you could stumble across a few annoyances.

If you don't [setup your SSH key correctly](https://help.github.com/articles/connecting-to-github-with-ssh/) you won't be able to pull from a private repository. If you don't mind putting in your password every time when executing `git pull` on the server you could use the [https version](https://help.github.com/articles/changing-a-remote-s-url/) of your GitHub/GitLab/Bitbucket URL

Another (quite hacky!) possibility is to move into your `./.git/config` file and write your password in there like this:

<embed-video code="locVoPXM3cg"> </embed-video>

You can now pull without an SSH key and being prompted for a password. But damn this feels ugly.

But what you also need to clear a cache of your application and install or update things like composer dependencies?

## Automate a deploy script with simple-ssh-commands

To do a little shameless plug here: I wrote a package called _simple-ssh-commands_ exactly to solve this problem.

The key idea is that you will have a file in your repository that states which series of commands needs to be run for a deploy to a server. Here is an example of this file in an Laravel project I worked on:

```bash
[
    {
        "commands": [
            "cd /var/www/website-live",
            "php artisan backup:run",
            "git pull",
            "composer install",
            "php artisan migrate --force",
            "php artisan clear-compiled",
            "php artisan view:clear",
            "php artisan config:clear"
        ],
        "host": "example.com",
        "username": "name"
    }
]
```

What is happening here should be quite clear. It's just a series of SSH commands which can be run with only one command.

I won't rehash everything I wrote the readme, so to keep this short just check out the project on [GitHub](https://github.com/simonvomeyser/simple-ssh-commands#readme) or [NPM](https://www.npmjs.com/package/simple-ssh-commands). I still use it in some projects and it works well 🙂

### Caveats

While this project served me and my clients well it still has a few downsides:

- You are executing the deploy yourself and need to coordinate with a team what you are doing.
- It still feels quite hacky
- Running tests has to be done locally
- There is still a lot that can go wrong

## Where to go next

You might have noticed these things top to bottom of this post get more and more complicated. The possible next step I would say is maybe check out a continuous integration setup with [GitLab](https://about.gitlab.com/product/continuous-integration/) (it's free!), use a service like [Runcloud](https://runcloud.io/) or check out [Forge](https://forge.laravel.com/) if you are using Laravel!


The main goal of this article was to show that there is a middle ground between cowboy deploy style ( 🔫 pew pew) with manual FTP uploads  and a total Docker/Kubernetes/AWS/Whatever craziness.

> Grow with your skills, try what is possible and gradually move away from FTP Clients.

## Notes from the Future

July 2020: You might also look into [Deployer](https://deployer.org/) for a PHP based solution - it looks promising.
