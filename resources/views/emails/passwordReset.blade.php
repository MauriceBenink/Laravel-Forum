@extends('emails/layout/mail')

@section('title')
    Password reset request
@endsection

@section('welcome')
    We received a request for {{$user->display_name}} if this is incorrect please contact a administrator
@endsection

@section('content')
    To complete the password reset please follow the following link :<br>
    <a href="http://{{$_SERVER['HTTP_HOST']}}/validate/password/{{$user->hashcode}}">http://{{$_SERVER['HTTP_HOST']}}/validate/password/{{$user->hashcode}}</a><br><br>

    If the link doesnt work please go to the validation page and enter the following code<br>
    {{$user->hashcode}}<br><hr>
@endsection