@extends('layouts.app')

@section('content')
    <p>Welcome, here are your blade posts</p>
    @foreach ($posts as $item)
        <a href="{{route('posts.single', $item->slug)}}">{{$item->title}}</a> <br><br>
    @endforeach

@endsection
