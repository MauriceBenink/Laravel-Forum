<div class="main-topic-body">
    <div class="title">
        {{$maintopic->name}}
    </div>
    <div class="description">
        {{$maintopic->description}}
    </div>
    <form action="{{url("forum/".$maintopic->id)}}">
        <input type="submit" value = "Go to">
    </form>
</div>