@extends('layouts.app')

@section('main')
<div class="container container--narrow">

    <h1> @yield('title') </h1>
    <img src="@yield('header_image')" alt="">
    <x-post-content>
        @yield('content')
    </x-post-content>
</div>

@endsection