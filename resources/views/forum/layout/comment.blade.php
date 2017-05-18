<div class="comment-container">
    <?php $author = $comment->author ?>
        <div class="author-body">
        @if(!is_null($author))
        <div class="author-png" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
            <img src="{{get_img($author->png)}}" height="45" width="45">
        </div>
        <div class="author-name" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
            {{$author->display_name}}
        </div>
        <div class="author-role">
            {!!($author->levelName->name)!!}
        </div>
        <div class="author-popularity">
            {{$author->popularity}}
        </div>
        @else
        <div class="author-png">
            <img src="{{defaultBanPNG()}}" height="45" width="45">
        </div>
        <div class="author-name">
            {{defaultBanDisplay()}}
        </div>
        <div class="author-popularity">
            {{defaultBanPop()}}
        </div>
    </div>


    @endif
    <div class="comment-body">
        <div class="comment-title">
            {{$comment->name}}
        </div>
        <div class="comment-content">
            {!! $comment->content !!}
        </div>
        @if(!is_null($author))
        @if(!is_null($author->comment_footer))
            <hr>
            <div class="comment-footer">
                {!! $author->comment_footer !!}
            </div>
            <hr>
            @endif
            @endif

    </div>
    <div class="comment-info">
        <div class="comment-rating">
            {{$comment->rating}}
        </div>
        <div class="comment-date">
            {{$comment->published_at,'YYYY/MM/DD'}}
        </div>
    </div>
    <hr>
</div>