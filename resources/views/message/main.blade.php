@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {!! session('returnError') !!}
            </div>
        </div>
    @endif

    <form action="{{url('message/inbox')}}">
        <?php $stuff = App\Messages::where('reciever',Auth::user()->id)->where('is_read',0)->get()->all(); ?>
        <input type="submit" value="Go to Inbox"> Unread Messages : {{!is_null($stuff)?count($stuff):0}}
    </form>
    <form action="{{url('message/outbox')}}">
        <input type="submit" value="Go to outbox">
    </form>
    <form action="{{url('message/send')}}">
        <input type="submit" value = "Send new Message">
    </form>


@endsection