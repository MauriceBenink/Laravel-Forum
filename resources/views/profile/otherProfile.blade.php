<?php
$profile = \App\profile::where('user_id',$user->id)->get()->first();
?>

@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="profile-left">
            <div class="img">
                <form action = '{{url("profile/avatar/$user->display_name")}}'>
                    <button style = "background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;outline:none;">
                        <img src="{{get_img($user->png)}}" height="45" width="45">
                    </button>
                </form>
            </div>
            <div class="display_name">{{$user->display_name}}</div>
            <div class="real_name">{{(isset($profile->name)&&!is_null($profile->name)?$profile->name:"not set")}}</div>
            <div class="level">{{(isset($user->levelName->name)&&!is_null($user->levelName->name)?$user->levelName->name:"not set")}}</div>
            <div class="bio">{!!(isset($profile->bio)&&!is_null($profile->bio)?$profile->bio:"not set")!!}</div>
            <div class="location">{{(isset($user->location)&&!is_null($user->location)?$user->location:"not set")}}</div>
            <div class="age">{{(isset($profile->birthday)&&!is_null($profile->birthday)?age($profile->birthday):"not set")}}</div>
            <div class="email">{{$user->email}}</div>
        </div>
        <div class="profile-left">
            <div class="site">{!!(isset($profile->site)&&!is_null($profile->site)?site_link($profile->site):"not set")!!}</div>
            <div class="b-day">{{(isset($profile->birthday)&&!is_null($profile->birthday)?carbon_date($profile->birthday):"not set")}}</div>
            <div class="github">{!!(isset($profile->github)&&!is_null($profile->github)?github($profile->github):"not set")!!}</div>
        </div>
    </div>

    <form action="{{url("profile/edit/".$user->display_name)}}">
        <input type="submit" value = "edit">
    </form>




@endsection