<ul>
    @foreach($object as $message)
        @if(!is_null($message))
            <li>
                <a href="{{url("message/view/$message->id")}}">
                @if($message->is_read)
                    {{$message->subject}}
                @else
                    <b>{{$message->subject}}</b>
                @endif
                </a>
                From : {{$message->sendBy->display_name}}
                To : {{$message->sendTo->display_name}}
            </li>
            <form action="{{url('message')}}" method="post">
                {{csrf_field()}}
                <input type="submit" value="Delete">
                <input type="hidden" value="{{$message->id}}" name="message">
            </form>
        @endif
    @endforeach
</ul>