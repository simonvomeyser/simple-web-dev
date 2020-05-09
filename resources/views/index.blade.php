@extends('layouts.app')

@section('main')
<section class="container">

    @if ($posts->count())

    <h1>The 3 most recent posts:</h1>

    <div class="posts">
        @each('includes.post-preview', $posts, 'post')
    </div>

    @else

    <h1>No posts found</h1>

    @include('includes.no-posts-found')

    @endif

</section>

@endsection