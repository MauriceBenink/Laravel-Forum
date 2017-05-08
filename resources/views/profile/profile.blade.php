<?php
$user = \App\profile::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get();
$auth = \Illuminate\Support\Facades\Auth::user();
?>

@extends('layouts/app')

@section('content')
<div class="container">
    <div class="profile-left">
        <div class="img"><img src="{{$auth->png}}" alt="{{defaultPNG()}}"></div>
        <div class="display_name">{{$auth->display_name}}</div>
        <div class="real_name">{{(isset($user->name)?$user->name:"not set")}}</div>
        <div class="level">{{(isset($auth->levelName->name)?$auth->levelName->name:"not set")}}</div>
        <div class="bio">{{(isset($user->bio)?$user->bio:"not set")}}</div>
        <div class="location">{{(isset($user->location)?$user->location:"not set")}}</div>
        <div class="age">{{(isset($user->bday)?age($user->bday):"not set")}}</div>
        <div class="email">{{$auth->email}}</div>
    </div>
    <div class="profile-left">
        <div class="site">{{(isset($user->site)?$user->site:"not set")}}</div>
        <div class="b-day">{{(isset($user->bday)?$user->bday:"not set")}}</div>
        <div class="github">{{(isset($user->github)?$user->github:"not set")}}</div>
        <div class="comment_footer">{{(isset($auth->comment_footer)?$auth->comment_footer:"not set")}}</div>
    </div>
</div>

<form action="profile/edit">
    <input type="submit" value = "edit">
</form>




    @endsection