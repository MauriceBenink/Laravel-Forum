@extends('emails/layout/mail')

@section('title')
    Registration email for Forum
    @endsection
@section('welcome')
    Welcome {!! $user->display_name !!} to the Laravel Forum website!
    @endsection
@section('content')
    To complete registration please follow the following link :<br>
    <a href="http://{{$_SERVER['HTTP_HOST']}}/validate/{{$user->hashcode}}">http://{{$_SERVER['HTTP_HOST']}}/validate/{{$user->hashcode}}</a><br><br>

    If the link doesnt work please go to the validation page and enter the following code<br>
    {{$user->hashcode}}<br><hr>
    @endsection
