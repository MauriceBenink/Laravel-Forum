<div class="nav">


    @if($type != 'maintopics')
    <form action="{{url('forum')}}">
        <input type="submit" value="{{BTM()}}">
    </form>
    @endif


    @if($type == 'subtopics')

        @endif


    @if($type == 'posts')
        <form action="{{url("forum/{$item->up->upper_level_id}")}}">
            <input type="submit" value="{{BTS()}}">
        </form>
        @if(newItem('post'))
            <br>
            <form action="{{route('newPost',['maintopic' => $item->up->upper_level_id,'subtopic' => $item->upper_level_id])}}">
                <input type="submit" value="Make new Post">
            </form>
            @endif
        @endif


    @if($type == 'comment')
        <form action="{{url("forum/{$item->up->up->upper_level_id}")}}">
            <input type="submit" value="{{BTS()}}">
        </form>
        <form action="{{url("forum/{$item->up->up->upper_level_id}/{$item->up->upper_level_id}")}}">
            <input type="submit" value="{{BTP()}}">
        </form>
        @if(newItem('comment'))
            <br>
            <form action="{{route('newComment',['maintopic' => $item->up->up->upper_level_id,'subtopic'=>$item->up->upper_level_id,"post" => $item->upper_level_id])}}">
                <input type="submit" value = "Make new Comment">
            </form>
            @endif
        @endif


    @if($type == 'nothing')
        @if(isset($back)&&!empty($back))

            @if(count($back) >= 1)
                <form action="{{url("forum/{$back['main']}")}}">
                    <input type="submit" value="{{BTS()}}">
                </form>
                @if(newItem($new) && $new == 'post')
                    <br>
                    <form action="{{url()->current().'/new'}}">
                        <input type="submit" value = "Make new Post">
                    </form>
                @endif

            @if(count($back) >= 2)
                <form action="{{url("forum/{$back['main']}/{$back['sub']}")}}">
                    <input type="submit" value="{{BTP()}}">
                </form>
                @if(newItem($new) && $new == 'comment')
                    <br>
                    <form action="{{url()->current().'/new'}}">
                        <input type="submit" value = "Make new Comment">
                    </form>
                @endif
            @endif
        @else
            @if(newItem($new)&&$new == 'subtopic')
                <br>
                <form action="{{url()->current().'/new'}}">
                    <input type="submit" value = "Make new SubTopic">
                </form>
            @endif
            @if(newItem($new)&&$new == 'maintopic')
                <br>
                <form action="{{url()->current().'/new'}}">
                    <input type="submit" value = "Make new MainTopic">
                </form>
            @endif
        @endif
    @endif

@endif
</div>