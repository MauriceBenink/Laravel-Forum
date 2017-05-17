<div class="sub-topic-body">
    <?php $author = $subtopic->author ?>
    <div class="title">
        {{$subtopic->name}}
    </div>
    <div class="description">
        {{$subtopic->description}}
    </div>
    <div class="author-body">
        @if(!is_null($author))
            <div class="author-name" onclick='window.location =" {{url("profile/show/$author->display_name")}}"'>
            {{$author->display_name}}
                @else
            <div class="author-name">
            {{defaultBanDisplay()}}
                @endif
        </div>
    </div>
    <form action="{{url_add($subtopic->id)}}">
        <input type="submit" value="Go To">
    </form>
</div>
