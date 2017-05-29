@extends('layouts/app')
<?php

?>


@section('content')
    <form action="{{url('adminPanel/Users')}}" id="users">
        <input type="submit" value="Show all users">
    </form>

    <form action="{{url('adminPanel/bannedPosts')}}">
        <input type="submit" value="Show Banned posts/comments">
    </form>

    <form action="{{url('adminPanel/UserGroups')}}" id="users">
        <input type="submit" value="Show all user Groups">
    </form>

    <form action="{{url('adminPanel/ContentGroups')}}" id="users">
        <input type="submit" value="Show all content Groups">
    </form>


@endsection