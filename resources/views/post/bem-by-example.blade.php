@extends('layouts.post')

@section('title', 'CSS Structure with BEM in a real world Example')

@section('release_date', 'November 2019')

@section('slug', 'bem-by-example')

@section('excerpt')

This little series is about writing better CSS by making use of BEM!

I currently find BEM immensely helpful but i did not find examples using it in a real world scenario.

@endsection

@section('tags', '["Frontend", "Tutorial"]')

@section('header_image', 'https://placehold.it/1024x768')

@section('list_header_image', 'https://placehold.it/1024x768')

@section('content')

<div class="post__content rich-text ">
    Hey there and welcome to this little series. It’s about writing better CSS by making use of nothing more than a
    naming convention, namely named BEM. Name-aste! 🧘‍♂️

    &nbsp;


    The <strong>B</strong>lock <strong>E</strong>lement <strong>M</strong>odifier concept (or the flavor of it I use)
    was <a href="http://getbem.com/">developed</a> by <a href="https://twitter.com/floatdrop">@floatdrop</a> and <a
        href="https://twitter.com/iamstarkov">@iamstarkov</a>.&nbsp; It does not require you to download or install
    anything, you can start in any new or existing project right away.


    <blockquote>
        This tutorial will have absolutely zero configuration and no build step.

    </blockquote>
    The reason why I am writing this post is that I currently find BEM immensely helpful for writing CSS but starting
    out, i did not find examples in a <em>real world scenario</em>. I watched a ton of tutorials but they all were using
    isolated demonstrations, requiring a lot of knowledge with other technologies&nbsp; or simply not answering
    questions I had in my current project.


    <blockquote>
        I am pretty much trying to write the tutorial I wish I had when I was starting out and wanted to structure my
        CSS better.

    </blockquote>
    Just a disclaimer: There are many other ways to structure your CSS and even many <a
        href="https://en.bem.info/methodology/naming-convention/#alternative-naming-schemes">naming schemes inside BEM
        itself</a>, what can be really confusing. In my opinion it’s more important to have a concept at all than which
    one it is so it&nbsp;<strong>does not matter</strong> all that much. I would suggest to start with an easy one
    tough… like… the one is this tutorial. I mean.. since you are already here, just stay 🙂


    I hope you will like my pragmatic approach I will apply to most of the coming decisions. Please feel free to
    disagree or change things when you have a good reason for it.&nbsp; In the end, there is no “right” way to do stuff.


    <blockquote>
        Relax, it’s all just opinions and tradeoffs.
    </blockquote>

    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535610398/BEM%20by%20Example/it-depends.jpg"
        width="1902" height="1573">

    <h2>What are we building</h2>

    What I want to provide is a <strong>How to implement a real world design with BEM step by step guide</strong>. In
    this scenario, a designer hands you a few JPGs and you should just<em> code that website bro</em>. Sadly, this is
    not that far from whats happening in many frontend jobs.

    We are going to implement the following single page layout I tried my non existant design skills at. Please don’t
    judge me to harshly.


    <img class="alignnone wp-image-87"
        src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535611665/BEM%20by%20Example/Demo.png" width="1701"
        height="1024">


    To make things a little bit more easy, you can <a
        href="https://www.figma.com/file/DyCnbDJJ38ODholutt2WtOfp/BEM-by-Example?node-id=0%3A1">look at the Design in
        Figma</a> . You can inspect the elements for colors there and export the images if you want to use the assets I
    used in this design. For that, you need to sign up for a free Figma account though. Just do it, <a
        href="http://blog.simonvomeyser.de/why-figma-stole-my-heart/">Figma is pure awesomeness</a>.


    If you want to be oldschool, <a
        href="https://res.cloudinary.com/simonvomeyser/image/upload/v1536816215/BEM%20by%20Example/Desktop.png">here is
        a jpg of the design</a> for you to download.


    We will start with the header in the next chapter and work our way through the content section to the footer in the
    other chapters. At the final chapter I will show some improvements to the workflow and and maybe add some JavaScript
    for toggling a mobile menu.


    <blockquote>
        This very article is meant as an introduction only

    </blockquote>
    I will cover only the BEM basics and why structuring your CSS is important at all. If you want to dive right in the
    implementation stuff of the design above, jump to the <a
        href="http://blog.simonvomeyser.de/bem-by-example-part-2-the-header/">second Part</a>&nbsp;where we put our
    pedal to the metal.


    <h2>Why structure your CSS at all</h2>
    I am not sure at which point in your career we two are having this odd, one sided conversation. Chances are that you
    are just starting out and getting your feet wet in webdevelopment land. You are maybe wondering, “why structure your
    CSS at all?”


    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535689359/BEM%20by%20Example/giphy.gif"
        width="640" height="480">


    This GIF pretty much sums it up: Even in small Projects your actions always seem to have unexpected results. Or like
    this joke puts it:


    <blockquote>
        Two CSS Selectors walk into a bar. A bar stool in a totally different bar falls over.

    </blockquote>
    Without a structure your styles somehow always seem to grow into a monolith containing all the projects rules, one
    overwriting the other, you sitting in a corner being afraid of any change requests by a customer.


    The cascading nature of CSS seems to add layer upon layer of complexity always resulting in something that looks
    good from the outside, but everybody is afraid to touch. Just like your mom.


    <img class="alignnone wp-image-93"
        src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535690029/BEM%20by%20Example/css_example.png"
        width="1598" height="774">


    Would you dare to make changes to Joes CSS on line 6857? Me neither. But don’t blame him, he got way better.


    I hope you agree that the example above is no way to live your life. So <strong>we need structure in our
        CSS</strong>. And sorry about the “your mom” joke earlier.


    <h2>The current state of CSS Structuring and why to choose BEM</h2>
    There are many ways out there to structure and use CSS in a project. Just look at all the colorful possibilities:


    <img class="alignnone wp-image-95"
        src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535798401/BEM%20by%20Example/css-framework-options.png"
        width="2004" height="1196">


    All these are not necessarily comparable, some are Framework, some are concepts, some include build systems. But
    they all have one thing in common: They scare and confuse the shit out of beginners.


    If you are at a stage where you don’t know how to start I have a rather pragmatic answer for you:&nbsp; Just use BEM
    as I will show you. This will give you a solid bang for your buck and you will later see similarities in almost
    every concept.


    Other reasons I would advise you to start with BEM:


    <ul>
        <li>It is a really easy approach you can start using today,</li>
        <li>No setup, just simple HTML and CSS knowledge required</li>
        <li>Battles&nbsp;<a href="https://developer.mozilla.org/en-US/docs/Web/CSS">Specificity</a>&nbsp;Problems quite
            will (meaning one style overwriting another)</li>
        <li>Lessens your fear of changing things later</li>
        <li>It’s a good segway into component based thinking like in React</li>
        <li>The more maintainable CSS will prevent you from Voodoo curses of future developers</li>
    </ul>
    <h2>BEM BAM BEM?! Let’s finally start!</h2>
    So after all this advertising, what the hell is BEM? In all it’s simplicity, the core concept is to structure your
    website into modules, meaning reusable parts. These are called <strong>Blocks</strong>, the <em>B</em> in BEM. A
    block should be something encapsulating its own styles and not being depended on it’s surroundings. So at the end,
    you should be able to drop a block anywhere on your site or even other sites and it should look exactly the same. If
    you ask me, that’s a little idealistic, but the core concept is really helpful.


    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535949544/BEM%20by%20Example/soundsgood.jpg"
        width="800" height="450">


    A block gets a simple, descriptive class name, for example like <em>newsletter</em>&nbsp;for styling a newsletter
    form. Since in this tutorial everything is about a practical examples, here we go: We will now build the following
    newsletter block really quick:


    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1535949719/BEM%20by%20Example/Bildschirmfoto_2018-09-03_um_06.41.28.png"
        width="390" height="209">


    Given this image we could start with the following markup:

    <x-code>
        <div class="newsletter">
            <div>Newsletter</div>
            <input type="email">
            <button>Unsubscribe</button>
            <button>Subscribe</button>
        </div>
    </x-code>

    Nothing more than a classname. That’s dead simple right?


    Inside of a block, you will have <em>Elements</em>. These are (most of the time) <em>direct</em> children of a
    block. To show that they belong to the block, their classname should now be the blocks name and then their own,
    connected by two underscores.


    So &lt;div&nbsp;<tt>class="newsletter__heading"&gt;</tt> thereby means the
    <strong>Element</strong>&nbsp;<em>Heading</em>&nbsp;is inside of the
    <strong>Block</strong>&nbsp;<em>Newsletter</em>. Not that complicated right?


    We end up with the following markup:

    <x-code>
        <div class="newsletter">
            <div class="newsletter__heading">
                Newsletter
            </div>
            <input type="email" class="newsletter__input">
            <button class="newsletter__button">Unsubscribe</button>
            <button class="newsletter__button">Subscribe</button>
        </div>
    </x-code>

    This looks a litte verbose and this is what some people don’t like about BEM. If you ask me, it’s really reasonable
    and you can understand at a glance what hierarchy is at play here. If you wrap the elements in divs or place the
    class name on them (like with the input) depends wholly on the context, both is possible.

    The last part of the puzzle is to explain how <strong>Modifiers</strong> work. These can be attached to elements (or
    blocks themself) to alter their appearance. In our example, and since we are dirty spammers that want people to
    subscribe, we want the second button to stand out more. We will&nbsp;<em>add</em> a modifier class like so.

    <x-code>
        <button class="newsletter__button">
            Unsubscribe
        </button>
        <button class="newsletter__button newsletter__button--call-to-action">
            Subscribe
        </button>
    </x-code>

    It’s important to combine the original class and the modifier class even if it looks a bit ugly (like your …) . This
    has a host of <a
        href="http://getbem.com/faq/#why-the-modifier-css-classes-are-not-represented-as-a-combined-selector-">reasons</a>
    but to keep it short: No CSS duplication, a more semantic markup and benefits of a higher specificity should be
    enough reason to endure a markup that is a little more verbose.

    <blockquote>
        You’ll get used to it, I promise 🙂
    </blockquote>
    For the CSS you should create a file containing all the blocks CSS and name it like the Block. So this content
    should go in a <code>newsletter.css</code>

    <x-code>
        .newsletter {
        text-align: center;
        }

        .newsletter .newsletter__heading {
        font-size: 2rem;
        margin-bottom: 1rem;
        }

        .newsletter .newsletter__input {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 1rem;
        min-width: 300px;
        }

        .newsletter .newsletter__button {
        padding: 0.5rem;
        color: #c0c0c0;
        background: #fafafa;
        font-size: 16px;
        }

        .newsletter .newsletter__button.newsletter__button--call-to-action {
        background: #74B9FF ;
        border-color: #74B9FF;
        color: white;
        }
    </x-code>

    Wohoo! We did our first frontend work using the BEM naming convention. You can find the whole example in this
    codepen:

    <div class="cp_embed_wrapper"><iframe name="cp_embed_1"
            src="https://codepen.io/simonvomeyser/embed/rroJzG?height=365&amp;theme-id=0&amp;slug-hash=rroJzG&amp;default-tab=css%2Cresult&amp;user=simonvomeyser&amp;pen-title=Simple%20BEM%20Newsletter%20Example&amp;name=cp_embed_1"
            scrolling="no" frameborder="0" height="365" allowtransparency="true" allowfullscreen="true"
            allowpaymentrequest="true" title="Simple BEM Newsletter Example" class="cp_embed_iframe "
            style="width: 100%; overflow:hidden; display:block;" loading="lazy" id="cp_embed_rroJzG"></iframe></div>
    <script async="" src="https://static.codepen.io/assets/embed/ei.js"></script>


    There are a lot of things we could discuss about this isolated example already, but this will happen in the next
    post often enough.

    Just to warn you in advance:

    <blockquote>
        What you will find is no perfect approach that will get you&nbsp;an A in your “How to use BEM in the 100%
        correct way” Exam.
    </blockquote>

    In my opinion, if you use BEM or name all your classes like Lord of the Rings characters (I actually saw that once)
    does not matter all that much for your client. But for maintainability it’s important that you have a system. I like
    BEM and it helped me in all kinds of projects.

    My approach will be really pragmatic and if you like it, we will have a great time. So let’s start, everybody ready?


    <a href="https://simple-web-dev.com/bem-by-example-part-2/">Off to the Part Two Mobile!</a>

    <img src="https://res.cloudinary.com/simonvomeyser/image/upload/v1536262168/BEM%20by%20Example/ezgif-2-9f1f6fb085.gif"
        width="499" height="279">


    @endsection