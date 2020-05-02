@props(['code', 'title'])

<figure class="video">
    <iframe @if($title ?? null) title="{{$title}}" @endif src="https://www.youtube.com/embed/{{$code}}?feature=oembed"
        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen="">
    </iframe>
</figure>