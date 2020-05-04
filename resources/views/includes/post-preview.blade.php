<article class="post-preview">
    <div class="post-preview__thumbnail">
        <a href="{{ $post->link() }}">
            <img src="{{$post->list_header_image}}" alt="List image of the post {{$post->title}}">
        </a>
    </div>
    <div class="post-preview__under-image">
        <div class="post-preview__meta">
            <div class="post-preview__categories">
                todo: categories
            </div>
            <div class="post-preview__est-reading-time">
                <div class="est-reading-time">
                    <span>{{$post->readingTime()}} min read</span>
                    <img src="{{asset('images/clock.svg')}}" alt="Symbol of a clock">
                </div>
            </div>
        </div>
        <div class="post-preview__heading">
            <h2>{{$post->title}}</h2>
        </div>
        <div class="post-preview__excerpt">
            <div>{{$post->excerpt}}</div>
        </div>
        <div class="post-preview__button">
            <a href="{{$post->link()}}" class="button">Read more</a>
        </div>

    </div>

</article>