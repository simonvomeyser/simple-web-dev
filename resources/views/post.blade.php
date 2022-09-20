@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', strip_tags($post->excerpt))
@section('og_type', 'article')
@section('og_image', $post->list_image)

@push('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
@endpush

@section('main')
<div class="container container--narrow">

    <div class="post">
        <div class="post__meta">
            <div class="post-meta">
                <div class="post-meta__heading">
                    <h1> {{$post->title}} </h1>
                </div>
                <div class="post-meta__date">
                    Written by Simon vom Eyser {{$post->getReadableRelease()}}
                </div>
                <div class="post-meta__tags">
                    @each('includes.tag-pill', $post->tags, 'tag')
                </div>
            </div>
        </div>
        <div class="post__image">
            <img src="{{$post->header_image}}"
                 width="658"
                 height="366"
                 alt="Header image of {{$post->title}}">
        </div>
        <div class="post__content rich-text">
            {{$post->content}}
        </div>
        <div class="post__author-link" >
            <div class="author" id="simon">
                <div class="author__head">
                    <div class="author__image">
                        <img src="{{asset('images/simon.png')}}" alt="Avatar of Simon">
                    </div>
                    <div class="author__meta">
                        <div class="author__name">Hey, want to connect?</div>
                        <div class="author__text">
                            I'm Simon, a web nerd from Germany. I like to meet new people, including you! <br> If you have questions, feedback or just want to say hi, feel free to reach out to me
                            <a href="https://twitter.com/simonvomeyser" target="_blank" rel="noopener noreferrer">on Twitter</a>.
                        </div>
                        <a href="https://twitter.com/simonvomeyser" rel="noopener noreferrer" target="_blank"
                           class="button button--min-width button--secondary">
                            <img src="{{asset('images/twitter.svg')}}" alt="Link symbol" style="margin-right: .25rem;">
                            Say hello!
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if ($post->similar())
            <div class="post__similar-heading">
                Read more posts
            </div>
            <div class="post__similar-list">
                @each('includes.post-preview', $post->similar()->take(2), 'post')
            </div>
        @endif
        <div class="post__back">
            <a href="/" class="button button--min-width button--secondary">Back to all posts</a>
        </div>

    </div>
</div>

@endsection
