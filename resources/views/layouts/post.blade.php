@extends('layouts.app')

@section('main')
<h1> Post Layout </h1>
<x-post-content>
    @yield('content')
</x-post-content>
@endsection