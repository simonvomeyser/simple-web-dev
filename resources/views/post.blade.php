@extends('layouts.app')

@section('main')
<div class="container container--narrow">

    <div class="post">
        <div class="post__back">
            <x-back />
        </div>
        <div class="post__meta">
            <div class="post-meta">
                <div class="post-meta__left">
                    <div class="post-meta__heading">
                        <h1> {{$post->title}} </h1>
                    </div>
                    <div class="post-meta__beneath-heading">
                        @each('includes.tag-pill', $post->tags, 'tag')
                    </div>
                </div>
                <div class="post-meta__right">
                    <div class="post-meta__author-image">
                        <img src="http://0.gravatar.com/avatar/cd029fe67e1a8a52e55bbed957848351?s=96&d=mm&r=g"
                            alt="Image of Simon trying to look professional">
                    </div>
                    <div class="post-meta__author">
                        written by Simon <br>
                    </div>
                    <div class="post-meta__date">
                        <div>{{$post->getReadableRelease()}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="post__image">
            <img src="{{$post->header_image}}" alt="Header image of {{$post->title}}">
        </div>
        <div class="post__content rich-text ">
            {{$post->content}}
        </div>

    </div>
</div>

@endsection