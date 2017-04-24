<div class="post-body">
    <div class="title">
        {{$post->name}}
    </div>
    <div class="description">
        {!!$post->content!!}
    </div>
    <div class="author-body">
        <div class="author-png">
            <img src="{{$post->author->png}}" alt="{{defaultPNG()}}">
        </div>
        <div class="author-name">
            {{$post->author->display_name}}
        </div>
    </div>

    @if(!isset($comment))
        <form action="{{url_add($post->id)}}">
            <input type="submit" value="Go To">
        </form>
    @endif

</div>
