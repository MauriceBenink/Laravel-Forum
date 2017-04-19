<div class="sub-topic-body">
    <div class="title">
        {{$subtopic->name}}
    </div>
    <div class="description">
        {{$subtopic->description}}
    </div>
    <div class="author-body">
        <div class="author-name">
            {{$subtopic->author->display_name}}
        </div>
    </div>
    <form action="{{url_add($subtopic->id)}}">
        <input type="submit" value="Go To">
    </form>
</div>
