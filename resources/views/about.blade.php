@extends('layouts.app')

@section('main')
<section class="container container--narrow">
    <div class="about">
        <div class="about__back">

        </div>
        <div class="about__heading">
            <h1>About simple web dev</h1>
        </div>
        <div class="about__copy">
            <p>
                This site is a small diary of the things I learn while on this journey through web development land.
            </p>
        </div>

        <div class="about__authors">
            <div class="author" id="simon">
                <div class="author__head">
                    <div class="author__image">
                        <img src="{{asset('images/simon.png')}}" alt="Avatar of Simon">
                    </div>
                    <div class="author__meta">
                        <div class="author__name">Simon vom Eyser</div>
                        <a href="https://simonvomeyser.com" rel="noopener noreferrer" target="_blank"
                           class="author__link">
                            <img src="{{asset('images/link.svg')}}" alt="Link symbol">
                            https://simonvomeyser.com
                        </a>
                        <a href="https://twitter.com/simonvomeyser" rel="noopener noreferrer" target="_blank"
                           class="author__link">
                            <img src="{{asset('images/twitter.svg')}}" alt="Link symbol">
                            @simonvomeyser
                        </a>
                        <a href="mailto:simon.vom.eyser@gmail.com" class="author__link">
                            <img src="{{asset('images/mail.svg')}}" alt="Link symbol">
                            simon.vom.eyser@gmail.com
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="about__copy">

            <p>
                I strongly believe in sharing knowledge and that everybody has something valuable to contribute. I'm neither the best developer nor writer, but I will still attempt to convey the things I learned. Ha! ... I also might crack a few jokes here and there.
            </p>

            <blockquote class="fancy-quote">
                <span>
                    But I am no super-genius. Or are I?
                </span>
                <footer>Homer J. Simpson</footer>
            </blockquote>

            <p>
                I have no idea where this experiment will lead to, but I want to try it, if only for the benefit of me getting out of my comfort zone and learning things more thoroughly while trying to explain them.
            </p>
            <p>
                Feel free to interact with me or send any feedback. If somebody besides my mum is interested in this blog I may add comments or will try to structure it a little better.
            </p>
            <p>
                That's all, take care! 🙂👍
                <br>- Simon
            </p>
        </div>

    </div>
</section>

@endsection
