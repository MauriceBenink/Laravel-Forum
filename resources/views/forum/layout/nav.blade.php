<div class="nav">


    @if($type != 'maintopics')
    <form action="{{url('forum')}}">
        <input type="submit" value="to main topics">
    </form>
    @endif


    @if($type == 'subtopics')

        @endif


    @if($type == 'posts')
        <form action="{{url("forum/{$item->up->upper_level_id}")}}">
            <input type="submit" value="back to sub topics">
        </form>
        @endif


    @if($type == 'comments')
            <form action="{{route('newComment',['maintopic' => $item->up->up->upper_level_id,'subtopic'=>$item->up->upper_level_id,"post" => $item->upper_level_id])}}">
                <input type="submit" value = "make new comment">
            </form>
        <form action="{{url("forum/{$item->up->up->upper_level_id}/{$item->up->upper_level_id}")}}">
            <input type="submit" value="back to posts">
        </form>
        @endif


    @if($type == 'nothing')
        @if(count($back) == 1)
            <form action="{{url("forum/{$back['main']}")}}">
                <input type="submit" value="Back to Subtopics">
            </form>
            @endif
        @if(count($back) == 2)
            <form action="{{url("forum/{$back['main']}/{$back['sub']}")}}">
                <input type="submit" value="Back to Posts">
            </form>
            @endif

        @endif
</div>