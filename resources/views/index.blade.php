@extends('layouts.app')

@section('main')
<section class="container">
    <form action="/" method="get" class="search-inline-form">
        <div class="search-inline-form__inner">
            <span class="search-inline-form__label-background"></span>
            <label for="search-input">Search</label>
            <input type="text" value="?" name="q" id="search-input"><button type="submit" class="button">find</button>
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

    @if ($posts->count())

    <div class="posts">
        @each('includes.post-preview', $posts, 'post')
    </div>

    @else

    <h1>No posts found</h1>

    @include('includes.no-posts-found')

    @endif

</section>

@endsection