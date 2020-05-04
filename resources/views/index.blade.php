@extends('layouts.app')

@section('main')
<section class="container">

    <h1>The 3 most recent posts:</h1>

    <div class="posts">
        @forelse ($posts as $item)
        <article class="post-preview">
            <div class="post-preview__thumbnail">
                <a href="{{ $item->link() }}">
                    <img src="{{$item->list_header_image}}" alt="List image of the post {{$item->title}}">
                </a>
            </div>
            <div class="post-preview__under-image">
                <div class="post-preview__meta">
                    <div class="post-preview__categories">
                        todo: categories
                    </div>
                    <div class="post-preview__est-reading-time">
                        todo: reading time
                    </div>
                </div>
                <div class="post-preview__heading">
                    <h2>{{$item->title}}</h2>
                </div>
                <div class="post-preview__excerpt">
                    <div>{{$item->excerpt}}</div>
                </div>
                <div class="post-preview__button">
                    <a href="{{$item->link()}}" class="button">Read more</a>
                </div>

            </div>

        </article>
        @empty
        <div class="no-posts">
            <img src="{{asset('images/found-nothing.svg')}}" alt="Oh no, a sad looking doggo">
        </div>
        @endforelse
    </div>
</section>


@endsection