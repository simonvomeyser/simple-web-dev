<article class="post-preview">
    <div class="post-preview__thumbnail">
        <a href="{{ $post->getLink() }}">
            <img class="lozad" data-src="{{$post->list_image}}" alt="List image of the post {{$post->title}}">
        </a>
    </div>
    <div class="post-preview__under-image">
        <div class="post-preview__meta">
            <div>Written {{$post->release_date->diffForHumans()}}</div>
            <div>
                <span>{{$post->readingTime()}} min read</span>
            </div>
        </div>
        <div class="post-preview__heading">
            <h2>{{$post->title}}</h2>
        </div>

        <div class="post-preview__excerpt">
            <div>{!! $post->excerpt !!}</div>
        </div>

        <div class="post-preview__button">
            <a href="{{$post->getLink()}}" class="button">Read more</a>
        </div>

    </div>

</article>