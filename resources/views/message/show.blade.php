@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif
    <?php $from = $message->sendBy; $to = $message->sendTo?>

    @if(!is_null($first))
        @include('message/layout/message',['object' => $first])
    @endif
    @if(!is_null($upper))
        @foreach($upper as $up)
            @include('message/layout/message',['object' => $up])
        @endforeach
    @endif
    @if(is_null($first)&&is_null($upper))
        @include('message/layout/message',['object' => $message])
    @endif

    <form action="{{url()->current()}}" method="post">
        {{csrf_field()}}}
        @include('message/layout/body',['type' => 'reply'])
    </form>


    <form action="{{url('message')}}">
        <input type="submit" value = "back to menu">
    </form>
    @endsection