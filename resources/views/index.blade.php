@extends('layouts.app')

@section('main')
<p>Welcome, here are your blade posts</p>

@forelse ($posts as $item)
<a href="{{route('posts.single', $item->slug)}}">{{$item->title}}</a> <br><br>
@empty
<p>{{__('posts.no-posts-found')}}</p>
@endforelse

@endsection