@extends('layouts.app')

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
                    Written by Simon {{$post->getReadableRelease()}}
                </div>
                <div class="post-meta__tags">
                    @each('includes.tag-pill', $post->tags, 'tag')
                </div>
            </div>
        </div>
        <div class="post__image">
            <img src="{{$post->header_image}}" alt="Header image of {{$post->title}}">
        </div>
        <div class="post__content markdown">
            {{$post->content}}
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