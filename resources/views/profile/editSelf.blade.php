<?php
$auth = \Illuminate\Support\Facades\Auth::user();
$user = \App\profile::where('user_id',$auth->id)->get()->first();

?>

@extends('layouts/app')

@section('content')
    @include('js/tinymc')

    <form method="POST" id = 'selfedit' role = "form" action="{{url()->current()}}">
        {{ csrf_field() }}


        @include('profile/layout/real_name',['object' => $user])

        @include('profile/layout/bio',['object' => $user])

        @include('profile/layout/location',['object' => $auth])

        @include('profile.layout.birthday',['object' => $user])

        @include('profile/layout/site',['object' => $user])

        @include('profile/layout/github',['object' => $user])

        @include('profile/layout/comment_footer',['object' => $auth])

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>

    @endsection