<?php
$user = \App\profile::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->first();
$auth = \Illuminate\Support\Facades\Auth::user();

?>


@extends('layouts/app')

@section('content')
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
        @endif
<div class="container">
    <div class="profile-left">

        <div class="img">
            <form action = '{{url("profile/avatar/$auth->display_name")}}'>
                <button style = "background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;outline:none;">
                    <img src="{{get_img($auth->png)}}" height="45" width="45">
                </button>
            </form>
        </div>

        <div class="display_name">{{$auth->display_name}}</div>
        <div class="real_name">{{(isset($user->name)&&!is_null($user->name)?$user->name:"not set")}}</div>
        <div class="level">{{(isset($auth->levelName->name)&&!is_null($auth->levelName->name)?$auth->levelName->name:"not set")}}</div>
        <div class="bio">{!!(isset($user->bio)&&!is_null($user->bio)?$user->bio:"not set")!!}</div>
        <div class="location">{{(isset($auth->location)&&!is_null($auth->location)?$auth->location:"not set")}}</div>
        <div class="age">{{(isset($user->birthday)&&!is_null($user->birthday)?age($user->birthday):"not set")}}</div>
        <div class="email">{{$auth->email}}</div>
    </div>
    <div class="profile-right">
        <div class="b-day">{{(isset($user->birthday)&&!is_null($user->birthday)?carbon_date($user->birthday):"not set")}}</div>
        <div class="site">{!! (isset($user->site)&&!is_null($user->site)?site_link($user->site):"not set")!!}</div>
        <div class="github">{!! (isset($user->github)&&!is_null($user->github)?github($user->github):"not set")!!}</div>
        <div class="comment_footer">{!! (isset($auth->comment_footer)&&!is_null($auth->comment_footer)?$auth->comment_footer:"not set")!!}</div>
    </div>
</div>

<form action="{{url('profile/edit')}}">
    <input type="submit" value = "edit">
</form>




    @endsection