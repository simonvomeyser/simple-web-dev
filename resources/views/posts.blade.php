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

    <h1>Welcome, here are all your blade posts</h1>

    <div class="posts">

        @each('includes.post-preview', $posts, 'post', 'includes.no-posts-found')

    </div>


</section>

@endsection