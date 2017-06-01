<div>To : {{is_null($to)?'cant find sender':$to->display_name}}</div>
<div>From : {{is_null($from)?'cant find reciever':$from->display_name}}</div>
<div>Subject : {{$object->subject}}</div>
<br>
{!!$object->message!!}
<hr>