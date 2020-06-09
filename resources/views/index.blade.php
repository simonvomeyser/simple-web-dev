@extends('layouts.app')

@section('main')
<section class="container">
    <morphing-headline></morphing-headline>
</section>
<section class="container">
    <form action="/" method="get" class="search-inline-form">
        <div class="search-inline-form__inner">
            <span class="search-inline-form__label-background"></span>
            <label for="search-input">Search</label>
            <input type="text" value="{{ $searchString ?? '' }}" name="q" id="search-input"><button type="submit" class="button">find</button>
        </div>
    </form>
    @if (isset($searchString))
        @if (!$posts->count())
            <div class="search-result-info">
                    Oh no, there are no posts when you search for that! 
                </div>
        @endif
            
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