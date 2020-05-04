@extends('layouts.app')

@section('main')
<div class="container">

    <p>Welcome, here are your blade posts</p>

    @forelse ($posts as $item)
    <div>
        <a href="{{ $item->link() }}">
            <img src="{{$item->list_header_image}}" alt="List image of the post {{$item->title}}">
        </a>
        <div>{{$item->title}}</div>
        <div>{{$item->excerpt}}</div>
    </div>
    @empty
    <p>{{__('posts.no-posts-found')}}</p>
    @endforelse
</div>


@endsection