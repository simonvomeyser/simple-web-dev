@extends('layouts.app')

@section('main')
<h1> @yield('title') </h1>
<img src="@yield('header_image')" alt="">
<x-post-content>
    @yield('content')
</x-post-content>
@endsection