@extends('layouts.post')

@section('title', 'BEM by Example – Part 2, the header')

@section('release_date', 'December 2019')

@section('slug', 'bem-by-example-part-2')

@section('excerpt')
This is the second part of my "BEM by Example" series.

In this post we will setup the project and then (finally, gosh! ?) implement the header of the Design.
@endsection

@section('tags', '["Frontend","Tutorial"]')

@section('header_image',
'https://res.cloudinary.com/simonvomeyser/image/upload/v1588611505/BEM%20by%20Example/bem-2-list-header-image.png')

@section('list_header_image',
'https://res.cloudinary.com/simonvomeyser/image/upload/v1588611505/BEM%20by%20Example/bem-2-list-header-image.png')

@section('content')

Howdy ho and welcome back! This is the second part of my BEM by Example series. If you skipped<a
    href="http://blog.simonvomeyser.de/css-structure-with-bem-in-a-real-world-example-part-1/"> the first part</a> make
sure you at least know what that <a href="http://getbem.com/">core concepts of BEM</a> are.

In this post we will setup the project and then (finally, gosh! ?) implement the header of the Design I showed you in <a
    href="https://blog.simonvomeyser.de/css-structure-with-bem-in-a-real-world-example-part-1/">Part 1</a>.

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1538713180/Header.png" width="1440" height="1081" />

This can be found <a href="https://www.figma.com/file/DyCnbDJJ38ODholutt2WtOfp/BEM-by-Example">on Figma</a>, where you
can get the exact colors and export assets. <a
    href="https://res.cloudinary.com/simonvomeyser/image/upload/v1536816215/BEM%20by%20Example/Desktop.png">Here is an
    old school image</a> if you want to travel the hard road.

You can of course use your own colors, background images and logos. Show me what you build! :)

Alongside of this tutorial you will find some boxes like the one after this paragraph. In there I will mention things
that are not necessarily important, yet interesting additional information. If you have no idea the title of the aside
means you can simply ignore it to not get confused. Nothing mandatory here.

<x-sidenote title="I am a side note, click me if you are a nerd.">

    Cool eh? I will contain some additional information for nerds like you and me.

    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1540881762/tenor.gif" width="480" height="360" />

</x-sidenote>

<h2>The first steps</h2>
The first thing I would do when a designer hands my such an amazing design like the on above is.. maybe hug him or her.
Designers need a lot of love because they get picked on for constantly drawing unicorns ? .

The thing I would do to prepare doing the frontend is trying to dissect the design and find the first "Block". My
attempt would maybe look something like this video. You can do that on a piece of paper or simply in your head

<figure
    class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio">
    <div class="wp-block-embed__wrapper">
        https://www.youtube.com/embed/vFJz-XFBmAQ

    </div>
</figure>

So you see I think we'll need a Block named <code>header</code> (or how you want) with two Elements, a
<code>navbar</code>  and an <code>image</code> . This might change during implementation, my workflow usually involves
refactoring later because I am not the sharpest tool in the shed. But in all seriousness:

<blockquote>
    Refactoring is always part of the process. Relax, nobody gets it perfect right away.

</blockquote>
Before we start to create a rough draft of the HTML we need to setup a project of course. No worries, this will be
really down to earth.

<h2>The minimal project setup</h2>
Since we want this example to be as straightforward as possible we are going to use no CSS preprocessor, no Webpack, no
parcel-di-gulpi-grunts. I know that all these things have enormous benefits but I want to keep this tutorial focused on
BEM.

If you have no idea what I am talking about: Just keep in mind that most modern projects usually will have a more
complicated setup. Since this has no benefit for understanding BEM we can simply start with a single HTML file and a
single CSS file. The way frontend web development used to be ... 'member? I 'member.

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1539064839/Group.png" width="503" height="317" />

The HTML file needs a few things that are a <a href="https://github.com/joshbuchea/HEAD#recommended-minimum">recommended
    minimum</a> for a modern website. We then include the stylesheet we will write in the next step and we are already
set in terms of our markup preparation.

<x-code>
    <!DOCTYPE html>
    <html>

    <head>
        <title>BEM by Example Part 2</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="app.css" />
    </head>

    <body>
        <!-- Lets bemgin here (? tss) -->
    </body>

    </html>
</x-code>

Now it's time to look at the basic styles!

<h2>Style prep, Global Styles and BEM</h2>
What to prepare before writing my first BEM Block was a big head-scratcher for me.

<blockquote>
    BEM Blocks should be independent, so should there be global styles at all?

    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1538977861/giphy.gif" width="480" height="366" />

</blockquote>
This is the first time I will turn in my alter ego "Pragmatic Man" and hope you will become my sidekick "Common Sense
Kid": I prefer to use a few minimal global styles as a setup even if that means not fully complying to the BEM principle
of complete Block reusability .

<x-code>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans');
    @import url('https://fonts.googleapis.com/css?family=Ropa+Sans');

    html {
    box-sizing: border-box;
    font-family: "Open Sans", sans-serif;
    font-size: 16px;
    }

    *, *:before, *:after {
    box-sizing: inherit;
    }

    body {
    margin: 0;
    padding: 0;
    }
</x-code>

As you see these defaults are pretty minimal. I am setting a bigger font-size and defaulting to a prettier font which I
imported. I am also <a href="https://css-tricks.com/international-box-sizing-awareness-day/">setting the box model</a>.
You could do all that on every component but I think it's just not practical.

<blockquote>
    Let's be honest: We are not going to port any of these blocks over to other sites
    right?

</blockquote>

Even if you do, you might want them to blend in and not to stand out because they use a completely different font or
font-size. The box model is something that should <a
    href="https://css-tricks.com/international-box-sizing-awareness-day/">be a default anyways</a> and setting margin
and padding on the body? Come on, let's not argue about stuff like that. It's simply not that important.

<blockquote>
    For me, BEM is more about structure inside a single project than about reusability
    across projects.

</blockquote>
I am not using any <a href="https://cssreset.com/what-is-a-css-reset/">resets</a>  because I think the <a
    href="http://getbem.com/faq/#global-css-resets">arguments</a> of the creators of BEM are quite good. You could
though, I don't judge.

<x-sidenote title="On BEM and Frameworks like Bootstrap, Fundation Tailwind and others">

    While it is totally possible to use a BEM naming convention and also use a CSS Framework (I did it quite often
    because
    they are awesome and help a lot) I nowadays would prefer not to. Your markup will stay way more concise since you
    will
    only use one naming convention and not mix it up.

    Something like this using Bootstrap 4 just does not appeal to me and is messy and confusing because it mixes naming
    conventions:

    <x-code>
        <header class="header mx-auto p-3">
            <div class="header__navbar bg-light">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- ... -->
                </nav>
            </div>
        </header>
    </x-code>

    Still, if you want to use Boostrap's (or some other Frameworks) immense power just do it. Pragmatic-Man would say:
    If it
    brings you more benefits than problems you already have your decision. You are smart enough to figure that out on
    your
    own :)

    <blockquote>
        What's most important is getting to work, so let's do that!

    </blockquote>
</x-sidenote>

<h2>Getting to work</h2>
The code I am writing can be cloned from <a href="https://github.com/simonvomeyser/bem-by-example">GitHub</a>. If you
ask yourself "What the hell is a GitHub and I hated the Clone Wars Star Wars movie" - don't sweat it, just download the
project files in a ZIP <a href="https://github.com/simonvomeyser/bem-by-example/archive/master.zip">here.</a>

After the setup in the last chapter we prepared the content of the <code>part-2/begin</code> folder. Starting from there
we will make changes until we arrive at the content of the <code>part-2/end</code> folder. You can now try it yourself
or just follow along with this tutorial, both is fine :)

What I like to do first is to create the markup from the <a href="#tutorial-video-1">rough ugly video</a> I showed you
above. It is important to go step by step from the outside to the inside.

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1544596308/header-marked-areas.png" width="1928"
    height="1179" />

So, our next steps would be to include the stylesheet in the head and then write a simple markup like this, one block
with two elements:

<x-code>

    <head>
        <!-- other header stuff -->
        <link rel="stylesheet" href="blocks/header.css">
    </head>

    <body>
        <header class="header">
            <div class="header__navbar">
                <!-- Navbar block will go here -->
            </div>
            <div class="header__image">
                The benefits of BEM
            </div>
        </header>
    </body>

    </html>
</x-code>

Are you still following? Just don't care about the navigation right now and look from the outside to the inside.

<blockquote>
    Always look at blocks in isolation is the key to not get confused!

</blockquote>
After grabbing the image in (from a <a
    href="https://www.figma.com/file/DyCnbDJJ38ODholutt2WtOfp/BEM-by-Example">Figma</a> <a
    href="https://help.figma.com/export/export-options">export</a>,  from <a
    href="https://res.cloudinary.com/simonvomeyser/image/upload/v1539585285/BEM%20by%20Example/Header_Hero_Image.png">here</a>
or any other <a href="https://unsplash.com/search/photos/technology-white">nice image from Unsplash</a>) I would only
style the <code>header.css</code> as shown here:


<x-code>
    .header {
    height: 100vh;
    display: flex;
    flex-direction: column;
    }
    .header .header__navbar {
    background-color: #04AEEE;
    height: 110px;
    }
    .header .header__image {
    flex: 1;
    background-size: cover;
    background-image: url(../images/header-hero.png);

    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 64px;
    color: #494949;
    font-family: 'Ropa Sans', sans-serif;
    }
</x-code>

The markup in combination with the styles does result in something that is already going in the right direction:

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1539235584/screenshot-without-nav.png" width="3360"
    height="1896" />

? Pretty good right? You could use another Block or Element for the big text saying "The benefits of BEM" but with all
that we know now this seems to be not necessary. Woho, progress. Let's go on!

<x-sidenote title="If you have problems understanding the CSS">

    This tutorial would be blown out of proportion if I would explain every line of CSS. This can't be a tutorial about
    how
    the awesomeness of Flexbox works or how other CSS magic is done.

    If you find yourself confused about the CSS and not about BEM itself: No problem, you need to take a step back and
    watch
    a few tutorials before going on here. Key is identifying <strong>where</strong> your head is stuck.

    There are a lot of beginner tutorials for CSS just a Google Search away. If it is  Flexbox what makes your head flex
    I
    can highly recommend <a href="https://flexbox.io/" target="_blank" rel="noopener noreferrer">Wes Bos and his
        tutorials</a> about that.

    <blockquote>
        Like with every problem or thing you don't understand: Dissect it into smaller in
        smaller pieces and attack them one be one.

    </blockquote>
    Don't feel bad, you can do it! ?‍??

</x-sidenote>

<h2>Nananana! Navbar!</h2>
The navbar should most certainly be <strong>it's own block </strong>to keep things structured. So now we are
<strong>only</strong> looking at the content of the <code>header__navbar</code> element. Again, isolation is key to not
get confused

<blockquote>
    When things start to get messy, chances are good you need to create a new block

</blockquote>
[rve src="https://www.youtube.com/embed/pPX8I8_GQVk" ratio="16by9"]

So my first guess for the markup would be like this,  the naming is arbitrary (call the block <em>batman-navbar
</em>or<em> gandalf-nav </em>if you want)

<x-code>
    ...

    <nav class="navbar">
        <div class="navbar__brand">
            Learn BEM
        </div>
        <div class="navbar__list">
            <!-- An ul element as block?  -->
        </div>
    </nav>

    ...
</x-code>

<x-sidenote title="On adding classes to the UL HTML element">

    There is something to be discussed: What should we do with the <code>ul</code> element containing the actual links
    of
    the menu? You could go all  <em>nucular </em>with BEM and create a list markup and a new Block like so:

    <x-code>
        <!-- Do not do it like this! -->
        <ul class="bad-menu">
            <li class="bad-menu__item">
                <a class="bad-menu__link" href="#about">Home</a>
            </li>
            <li class="bad-menu__item bad-menu__item--active">
                <a class="bad-menu__link" href="#about">About</a>
            </li>
            ...
        </ul>
    </x-code>

    This seems to be good BEM practice, heck I just talked about creating Blocks in Blocks in Blocks right?
    Unfortunately
    menus are a little special:

    When you  are working with a backend like Wordpress or Drupal that maybe generates the markup it is a big hassle to
    let
    a CMS  exactly output the BEM classes. It simply means more work we can take of the shoulders of a backend
    developer.

    So even on a site without a backend I just omit the list classes and style them by targeting the <code>ul</code>,
    <code>li</code> or <code>a</code> tags directly.

    <blockquote>
        I accustomed myself to not adding any BEM classes to menu list elements, but that's
        just my opinion.

    </blockquote>
</x-sidenote>

Well Pragmatic man, what should the markup look like when we add the UL HTML element?

<x-code>
    <nav class="navbar">
        <div class="navbar__brand">
            Learn BEM
        </div>
        <div class="navbar__list">
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#benefits">Benefits</a></li>
                <li><a href="form">Form</a></li>
            </ul>
        </div>
    </nav>
</x-code>

Pretty approachable right? Let's jump to they styles, they still look pretty understandable I think:


<x-code>
    .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 900px;
    margin: auto;
    }
    .navbar .navbar__brand {
    font-size: 48px;
    font-family: 'Ropa Sans', sans-serif;
    color: #B6DAFF;
    }
    .navbar .navbar__list ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    }
    .navbar .navbar__list li {
    margin: 0;
    padding: 0;
    }
    .navbar .navbar__list li+li {
    margin-left: 2rem;
    }
    .navbar .navbar__list a {
    font-size: 24px;
    color: #B6DAFF;
    text-decoration: none;
    }
</x-code>

This might make some people cringe, but I find it is a good balance between verbosity and complexity in your CSS and in
your HTML. The logic has to go somewhere right?

Also we do only affect lists inside of this component, so there is no damage done in terms of maintainability and
specificity.

So where do we end up?

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1539665410/_Users_simonvomeyser_oc_projects_teaching_bem-by-example_part-2_end_index.html.png"
    width="1318" height="978" />

Wopdy doo! So we are all done, call the client, cash your check. Wait.. aren't we missing something starting with an "m"
and ending with "obile"?

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1544422605/bem_mobile_fire.gif" width="1280"
    height="720" />

Aww snap, back to the drawing board.

<h2>Mobile styles</h2>
One of the things I always wondered was where to put my media queries. With BEM, this ist quite approachable:
<strong>Just put them into the Block they belong to</strong>. This does help a lot with maintainability since you
exactly know where to search when something goes sideways.

<blockquote>
    Each block is only responsible for it's own behaviour on different viewports

</blockquote>
In our situation, the content of the <code>navbar</code> is clearly off, so let's repeat our mantra "I will look at
things in isolation".  When looking only at this block (in the <code>navbar.css</code> file) it is a quick fix, we add a
media query and turn on <code>flex-wrap</code>, center the elements and maybe decrease the font a little.

<x-code language="css">
    @media (max-width: 900px) {
    .navbar {
    flex-wrap: wrap;
    justify-content: center;
    }
    .navbar .navbar__brand {
    text-align: center;
    width: 100%;
    font-size: 34px;
    }
    .navbar .navbar__list a{
    font-size: 18px;
    }
    }
</x-code>

Note that this is only one way to do it. This tutorial is not about the best mobile styles and the way I did it here
will look butt ugly when we add more links to the menu. Also the approach here is not really mobile first... but it does
the job!

<x-sidenote title="On mobile first">

    There are a myriad of reasons I am not doing this tutorial in a mobile first manner. The main one is that this post
    is
    all about didactics meaning how does someone learn the best way. People that are coding alongside a tutorial and
    using
    it as reference are most likely doing that on a desktop machine.

    I also try to be not that dogmatic about mobile first in general. I can clearly see the benefits and a lot has been
    <a href="https://mayvendev.com/blog/mobilefirst">written and discussed</a> about this issue. I develop mobile first
    from time to time, but as long as you are empathic towards your users, your development is not taking way too long
    and
    the <strong>end product </strong>is serving the customer well, does it really matter how you got there? Evaluate the
    tradeoffs and do what you (and your team) thinks will create the best software for the customer. Just my two 50
    cents.

    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1540301660/2_50_cents.png" width="2020"
        height="1020" />

</x-sidenote>

Put the media queries in the file belonging to the block. Following that mantra, we decrease the font size of the big
title saying "BEM by Example". We will do that in the file (drumroll please) <code>header.css</code> since the other
styles of the big title are there too.

<x-code>
    @media (max-width: 900px) {
    .header .header__image {
    font-size: 44px;
    text-align: center;
    }
    }
</x-code>

Smaller font size, center all content in it, tadaa... it really seems like we are done with the header this time :)

<img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1540443950/Kapture_2018-10-25_at_7.05.06.gif"
    width="1028" height="578" />

<h2>Last words</h2>
Like with everything in development there are so many things we could have done differently but I hope you got the
basics of how to approach frontend work BEM-Style. Yo!

There is still a lot to say so let me know if you want to see a third part where I will try to not fuck up the other
parts of the <a href="https://res.cloudinary.com/simonvomeyser/image/upload/v1536816215/BEM%20by%20Example/Desktop.png"
    target="_blank" rel="noopener noreferrer">design</a>. ?

@endsection