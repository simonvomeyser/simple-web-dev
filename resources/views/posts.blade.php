@extends('layouts.app')

@section('main')
<section class="container">
    <form action="todo" method="get" class="search-inline-form">
        <div class="search-inline-form__inner">
            <span class="search-inline-form__label-background"></span>
            <label for="search-input">Search</label>
            <input type="text" value="?" name="s" id="search-input"><button type="submit" class="button">find</button>
        </div>
    </form>
    <div class="search-result-info">
        Found ??
    </div>
    <div class="search-result-info">
        Found ??
    </div>
</section>
<section class="container">

    <p>Welcome, here are all your blade posts</p>

    @forelse ($posts as $item)
    <div>
        <a href="{{ $item->link() }}">
            <img src="{{$item->list_header_image}}" alt="List image of the post {{$item->title}}">
        </a>
        <div>{{$item->title}}</div>
        <div>{{$item->excerpt}}</div>
    </div>
    @empty
    <div class="no-posts">
        <img src="{{asset('images/found-nothing.svg')}}" alt="Oh no, a sad looking doggo">
    </div>
    @endforelse

    </div>
</section>

@endsection