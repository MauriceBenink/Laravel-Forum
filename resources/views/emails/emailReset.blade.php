@extends('emails/layout/mail')

@section('title')
    Email Change for Laravel Forum
@endsection
@section('welcome')
    Request for Email change for {!! $user->display_name !!}
@endsection
@section('content')
    To complete Email Change please follow the following link :<br>
    <a href="http://{{$_SERVER['HTTP_HOST']}}/validate/email/{{$user->hashcode}}">http://{{$_SERVER['HTTP_HOST']}}/validate/email/{{$user->hashcode}}</a><br><br>

    If the link doesnt work please go to the validation page and enter the following code<br>
    <i>{{$user->hashcode}}</i><br><hr>
@endsection
