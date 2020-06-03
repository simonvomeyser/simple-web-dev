@extends('layouts.app')

@section('main')
<section class="container">
    <form action="/" method="get" class="search-inline-form">
        <div class="search-inline-form__inner">
            <span class="search-inline-form__label-background"></span>
            <label for="search-input">Search</label>
            <input type="text" value="{{ $searchString ?? '' }}" name="q" id="search-input"><button type="submit" class="button">find</button>
        </div>
    </form>
    @if (isset($searchString))
        <div class="search-result-info">
            @if ($posts->count())
                Wohoo! I found {{$posts->count()}} posts with that!
            @else
                Oh no, there are no posts when you search for that! 
            @endif
        </div>

        <div class="search-result-info">

            <a href="{{route('index')}}">clear search</a>
        </div>
    @endif
</section>

<section class="container">

    @if ($posts->count())

    <div class="posts">
        @each('includes.post-preview', $posts, 'post')
    </div>

    @else

    @include('includes.no-posts-found')

    @endif

</section>

@endsection