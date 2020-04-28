@props(['code', 'title'])

<figure class="video">
    <iframe title="{{$title}}" src="https://www.youtube.com/embed/{{$code}}?feature=oembed" frameborder="0"
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
    </iframe>
</figure>