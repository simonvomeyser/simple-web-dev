@extends('layouts.app')

@section('main')
<section class="container">

    <h1>The 3 most recent posts:</h1>

    <div class="posts">

        @each('includes.post-preview', $posts, 'post')

    </div>
</section>


@endsection