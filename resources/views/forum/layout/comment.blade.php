<div class="comment-container">
    <div class="author-body">
        @if(!is_null($comment->author))
        <div class="author-png">
            <img src="{{$comment->author->png}}" alt="{{defaultPNG()}}">
        </div>
        <div class="author-name">
            {{$comment->author->display_name}}}}
        </div>
        <div class="author-role">
            {!!($comment->author->levelName->name)!!}
        </div>
        <div class="author-popularity">
            {{$comment->author->popularity}}
        </div>
        @else
        <div class="author-png">
            <img src="{{defaultBanPNG()}}" alt="{{defaultPNG()}}">
        </div>
        <div class="author-name">
            {{defaultBanDisplay()}}
        </div>
        <div class="author-role">
            {{defaultBanRole()}}
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
        @if(!is_null($comment->author))
        @if(!is_null($comment->author->comment_footer))
            <hr>
            <div class="comment-footer">
                {!! $comment->author->comment_footer !!}
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