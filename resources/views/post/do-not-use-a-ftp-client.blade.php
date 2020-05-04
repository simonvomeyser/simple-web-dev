@extends('layouts.post')

@section('title', 'You might not need a FTP client to deploy your website…')

@section('release_date', 'February 2020')

@section('slug', 'do-not-use-a-ftp-client')

@section('excerpt')

For a long time I was really hesitant to dive into the world of alternatives to FTP Clients for deployment.

But there are a few small steps that really are easy without sailing rough seas on docker ships.

@endsection

@section('tags', '["Backend","Dev Ops"]')

@section('header_image', 'https://placehold.it/1024x768')

@section('list_header_image', 'https://placehold.it/1024x768')

@section('content')

For a long time I was really hesitant to dive into the world of alternatives to FTP Clients
when I wanted to deploy, upload or update a web project.

<div style="display: flex; justify-content: center;">
    <twitter-widget class="twitter-tweet twitter-tweet-rendered" id="twitter-widget-0"
        style="position: static; visibility: visible; display: block; transform: rotate(0deg); max-width: 100%; width: 500px; min-width: 220px; margin-top: 10px; margin-bottom: 10px;"
        data-tweet-id="1064532628664143872"></twitter-widget>
</div>


<script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

A story from some time ago could have been as follows: I fired up <em>FileZilla</em>&nbsp;and dragged and dropped
the
changed files over.&nbsp;Did I get all of them? Refresh the live page.. ouoh.. an Error


… the telephone rings a few seconds later. Client: “Why is our website down, we are loosing money”. Sweat, Fear,
Airplanes crashing in the background. Better re-upload the whole project to be sure. Remaining: 10000 files,
estimate 2 hours. Ahhh.. better walk up and down the office and pull my hair until the upload is completed.


<img class="wp-image-267 aligncenter"
    src="https://res.cloudinary.com/simonvomeyser/image/upload/v1548395231/dont-use-ftp/dog.gif" width="480"
    height="270">


If this sounds at least a little bit familiar you have seen the ugly side that comes with FTP Clients and their
simplicity. I always knew that there were much better ways to get our website up onto servers… but it all felt too
overwhelming.


A virtual Machine on the clients cheap Hosting? No way! A Docker Container for each new deployment? Erm okay… A
continuous integration pipeline? <strong>You’re a pipeline!</strong>


While I nowadays use and love some of these tools, I discovered that there are also some really simple things you
can
do to greatly improve your ability to sleep at night when deploying a project.

<blockquote>
    There are some small wins you can improve your deployment process with that are
    not
    crazy complicated!

</blockquote>
<x-sidenote title="Read more: On using Git">
    You should <strong>always</strong> use a version control system! If you don’t do it some of these tricks
    won’t work.


    If you think it is too complicated for your simple project chances are good you just need to familiarize
    yourself more with git in general. The basics are really easy and highly beneficial.


    Believe me, I am all and always for keeping things simple but in this case the benefits far outweight the
    costs. Just do it!


    <img class="wp-image-268 aligncenter"
        src="https://res.cloudinary.com/simonvomeyser/image/upload/v1548395373/dont-use-ftp/justdoit.gif" width="1280"
        height="720">

</x-sidenote>

<h2>rsync and other command line tools</h2>

To be honest I always shied away from these because it just seemed to much to remember. Most of them only partly
work
on windows and the setup looked like this to me:


<x-code>
    blasync -wtf -bLa /usr/bin/wtf --force --danger site-to-destroy.com
</x-code>

And I was like “no way I am even trying that, my computer will blow up or try to kill all humans if I do”


<img class="wp-image-273 aligncenter"
    src="https://res.cloudinary.com/simonvomeyser/image/upload/v1548577943/dont-use-ftp/200.gif" width="287"
    height="200">


To be a little less childish here: Rsync in particular works great for doing exactly what it name sounds like:
Syncing folders between two places, be it between two folders (f.e. for backup) or two machines (f.e. your dev
machine and a server).


Maybe you want to download all user uploaded files in a cms like wordpress of drupal to your local dev machine.
Maybe
you want to manually backup your files (don’t, please don’t).

<blockquote>
    It really can play out it strengths when you only want to sync differences.
</blockquote>

<h3>What should I do?</h3>

Between two folders it is really easy to use rsync:


<x-code>
    rsync -a my-files/ backup/
</x-code>

This will sync all files from <code>my-files</code> to <code>backup</code>. The parameter <code>-a</code> says it
should include subfolders and preserve file properties


An example to download all files from a remote folder would be:

<x-code>
    rsync -a ssh-username@domain.com:/www/htdocs/some-website/uploads ~/Desktop/uploads
</x-code>

When you now turn this around, you could simply sync your directory you develop your website in and only upload the
changes, rsync does all this comparing work for you. Use this:

<x-code>
    rsync -a ~/Desktop/my-website/ ssh-username@domain.com:/www/htdocs/my-webiste/
</x-code>

Of course there are thousand of option how to overwrite, ignore some, show progress, test run before you nuke
anything and so on. I found a <a href="https://www.youtube.com/watch?v=qE77MbDnljA">cool video</a> that will help
you get started 🙂

<h3>Caveats</h3>

As I already said this is not as easy on Windows as it is on Mac or Linux. It will also feel quite hacky and you
might be nervous before hitting ‘Enter’. Just save the command you will use regularly somewhere so the probability
of setting something on fire is little bit smaller.

<h2>Git-ftp</h2>

This <a href="https://github.com/git-ftp/git-ftp">project</a>&nbsp; is a really elegant solution that actually still
uses FTP under the hood. But instead of flipping open your FTP Client (and endangering everyone around you) it will
only upload the files you changed after the last upload you did.


What a relieve already knowing that <em>exactly</em> the files you changed will be uploaded! Old files will be
deleted and each “push” only takes a few seconds.

<blockquote>
    I was initially hesitant to use it because I did not understand that git-ftp does
    not
    really care what is on your server.

</blockquote>

But the way it works is really easy, it just adds a file to your server where the hash of your last commit is
stored.
When you want to “push” it first looks for this hash in the text file, checks what has happened since then and only
uploads the difference. No magic there.


You can actually do the setup of a site with your ftp client of choice, make it work and only use git ftp from there
for updates.

<h3>What should I do?</h3>

Your workflow now there is really easy: Work locally, commit and push with Git .. and when you want to “deploy” your
site just execute <code>git-ftp push</code> and your files will be uploaded. But.. what about ignored files and so
on?


The simplest way in an existing project to get going with git-ftp is:


<a href="https://github.com/git-ftp/git-ftp/blob/master/INSTALL.md">Install it</a> and then add the config (These
are
stored in the file <code>.git/config</code>&nbsp;if you ever want to change them)

<x-code>

    git config git-ftp.url "ftp://your-website.net:21/the_location/"
    git config git-ftp.user "ftp-user"
    git config git-ftp.password "secr3t"

</x-code>

And tell git-ftp to use the current state as a starting point only.

<x-code>

    git ftp catchup

</x-code>

Then you work and work and work, (hopefully) commit a lot, push, merge and do all the git craziness we love and
still
don’t understand fully.


When you want to “deploy” your site, just run the following command:

<x-code>

    git ftp push

</x-code>

And voilà: Your file should be online in no time.


There are a lot of <a href="https://github.com/git-ftp/git-ftp/blob/master/man/git-ftp.1.md">advanced options</a>
but
these few lines of the code above have made my life a lot better already&nbsp; 🥰

<h3>Caveats</h3>

When you work in a team you need to communicate who does the deployments and make sure that not two persons are
executing a git-ftp push at the same time.


I also ran into some issues with changing a site from production to live in another folder… but that was nothing a
quick googly google search could not fix.


This project is awesome!

<h2>git pull with ssh</h2>

Git is a wonderful tool. It already knows about all the things you changed and what the current state of your
website
<em>should</em>&nbsp;be. Why not use that, even without something like git-ftp?


When your hoster offers the possibility to connect to your server via SSH you could just connect, move into the
directory of your website and execute a <code>git pull</code> Easy right?


[rve src=”https://www.youtube.com/embed/vpz71ZSR4iQ” ratio=”16by9″]


Of course it’s a little more complicated and there are a few prerequisites aside from an SSH connection:

<ul>
    <li>You will need a central repository somewhere your server can reach and pull from. So if your project is
        already
        on (for example) GitHub, GitLab or Bitbucked you are set.</li>
    <li>Git has to be installed on the server. Test it with a quick <code>git --version</code>. Otherwise <a
            href="https://www.atlassian.com/git/tutorials/install-git">install it</a>&nbsp; or ask your hoster to do
        that.</li>
    <li>As your local version, the server needs to know that your site is a git rep. You could do that in two ways:
        <ul>
            <li>I would strongly advise to re-setup your site when you have started without git. Just run a
                <code>git clone</code>&nbsp;on the server and everything is setup for you.</li>
            <li>You could also upload the hidden <code>.git</code> folder (via FTP 😱) and try your luck from there.
                This could become very complicated though</li>
        </ul>
    </li>
</ul>
<h3>Caveats</h3>

While the theory is quite simple you could stumble across a few annoyances.


If you don’t <a href="https://help.github.com/articles/connecting-to-github-with-ssh/">setup your SSH key
    correctly</a> you won’t be able to pull from a private repository. If you don’t mind putting in your password
every time when executing <code>git pull</code> on the server you could use the <a
    href="https://help.github.com/articles/changing-a-remote-s-url/">https version</a> of your
GitHub/GitLab/Bitbucked URL


Another (quite hacky!) possibility is to move into your&nbsp;<code>./.git/config</code> file and write your password
in there like this:


https://www.youtube.com/watch?v=locVoPXM3cg?autoplay=1&amp;mute=1&amp;playlist=locVoPXM3cg


You can now pull without an SSH key and being prompted for a password. But damn this feels ugly.


But what you also need to clear a cache of your application, install or update possible dependencies and execute a
myriad of other things on the server?

<h2>Automate a deploy script with simple-ssh-commands</h2>

To do a little shameless plug here: I wrote a package called *simple-ssh-commands* exactly to solve this problem.


The key idea is that you will have a file in your repository that states which series of commands needs to be run
for
a deploy to a server. Here is an example of this file in an old Laravel project I worked on

<x-code>
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
</x-code>

What is happening here should be quite clear. It’s just a series of SSH commands which can be run with only one
command.


I won’t rehash everything I wrote the readme, so to keep this short just check out the project on <a
    href="https://github.com/simonvomeyser/simple-ssh-commands#readme">GitHub</a> or <a
    href="https://www.npmjs.com/package/simple-ssh-commands">NPM</a>. I still use it in some projects and it works
well 🙂

<h3>Caveats</h3>

While this project served me and my clients well it still has a few downsides:

<ul>
    <li>You are executing the deploy yourself and need to coordinate with a team what you are doing.</li>
    <li>It still feels quite hacky</li>
    <li>Running tests has to be done locally</li>
    <li>There is still a lot that can go wrong</li>
</ul>
<h2>Where to go next</h2>

You might have noticed these things top to bottom of this post get more and more complicated. The possible next step
I would say is maybe check out a continuous integration setup with <a
    href="https://about.gitlab.com/product/continuous-integration/">GitLab</a> (it’s free!), use a service like <a
    href="https://runcloud.io/">Runcloud</a>&nbsp; or (for you Laravel folks &lt;3) check out <a
    href="https://forge.laravel.com/">Forge</a> and <a href="https://envoyer.io/">Envoyer</a>, they are awesome!


The main goal of this article was to show that there is not an either-or situation between cowboy coding style (pew
pew) manual FTP uploads or a total Docker/Kubernetes/AWS/Whatever craziness.

<blockquote>
    Grow with your skills, try what is possible and gradually move away from FTP
    Clients.
</blockquote>

@endsection