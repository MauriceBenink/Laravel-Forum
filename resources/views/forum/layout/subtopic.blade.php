<div class="sub-topic-body">
    <div class="title">
        {{$subtopic->name}}
    </div>
    <div class="description">
        {{$subtopic->description}}
    </div>
    <div class="author-body">
        <div class="author-name">
            @if(!is_null($subtopic->author))
            {{$subtopic->author->display_name}}
                @else
            {{defaultBanDisplay()}}
                @endif
        </div>
    </div>
    <form action="{{url_add($subtopic->id)}}">
        <input type="submit" value="Go To">
    </form>
</div>
