@extends('layouts.app')

@section('main')
<section class="container container--narrow">
    <div class="about">
        <div class="about__back">
            todo, back
        </div>
        <div class="about__heading">
            <h1>About simple web dev</h1>
        </div>
        <div class="about__explaination">
            <p>
                This site is a small blog called simple web dev (you might have picked that up by now).
            </p>
            <p>
                We strive to provide simple yet helpful articles about things we learn every day in the world of web
                development. This blog should do nothing more and nothing less than to share some knowledge about our
                favorite technologies like Laravel, Vue.js and React. We also write about the Frontentd, UX,
                Productivity, Tooling and attempt a few shots at Dev Ops.
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
                        <a href="https://simonvomeyser.de" rel="noopener noreferrer" target="_blank"
                            class="author__link">
                            <img src="{{asset('images/link.svg')}}" alt="Link symbol">
                            https://simonvomeyser.de
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
                <div class="author__copy">
                    <p>
                        Hey, I’m Simon vom Eyser and I am freelancing web developer from NRW, Germany, (“Hi Simon,
                        welcome to our self help group”)
                    </p>
                    <p>
                        I like coffee, bad jokes and yet still try to be a professional which is quite an interesting
                        endeavour. I’m involved in web development since the good old Myspace days and couldn't imagine
                        a job I like doing more ☺️
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection