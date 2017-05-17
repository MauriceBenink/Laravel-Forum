<div class="post-body">
    <div class="title">
        {{$post->name}}
    </div>
    <hr>
    <div class="description">
        {!!$post->content!!}
    </div>
    <div class="post-footer">
        {!! $post->author->comment_footer !!}
    </div>
    <?php $author = $post->author ?>
    @if(!is_null($author))
    <div class="author-body">
        <div class="author-png">
            <img src="{{get_img($author->png)}}"height="45" width="45" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
        </div>
        <div class="author-name" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
            {{$author->display_name}}
        </div>
    </div>
        @else
    <div class="author-body">
        <div class="author-png">
            <img src="{{defaultBanPNG()}}" height="45" width="45">
        </div>
        <div class="author-name">
            {{defaultBanDisplay()}}
        </div>
    </div>
        @endif

    @if(!isset($comment))
        <form action="{{url_add($post->id)}}">
            <input type="submit" value="Go To">
        </form>
    @endif

</div>
