@extends('layouts.app')

@section('content')
    <p>Welcome, here are your blade posts</p>
    @foreach ($posts as $item)
        {{$item->title}}
    @endforeach

@endsection
