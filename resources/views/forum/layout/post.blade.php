<div class="post-body">
    <div class="title">
        {{$post->name}}
    </div>
    <div class="description">
        {{$post->description}}
    </div>
    <div class="author-body">
        @if(!is_null($post->author))
        <div class="author-png">
            <img src="{{get_img($post->author->png)}}" height="45" width="45" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
        </div>
        <div class="author-name" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
            {{$post->author->display_name}}
        </div>
            @else
            <div class="author-png">
                <img src="{{defaultBanPNG()}}" height="45" width="45">
            </div>
            <div class="author-name">
                {{defaultBanDisplay()}}
            </div>
            @endif
    </div>

    @if(!isset($comment))
        <form action="{{url_add($post->id)}}">
            <input type="submit" value="Go To">
        </form>
    @endif

</div>
