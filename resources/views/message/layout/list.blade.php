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
                <?php $sendby = $message->sendBy ?>
                From : {{is_null($sendby)?'cant find sender':$sendby->display_name}}
                <?php $sendto = $message->sendTo ?>
                To : {{is_null($sendto)?'cant find reciever':$sendto->display_name}}
            </li>
            <form action="{{url('message')}}" method="post">
                {{csrf_field()}}
                <input type="submit" value="Delete">
                <input type="hidden" value="{{$message->id}}" name="message">
            </form>
        @endif
    @endforeach
</ul>