<?php
$profile = \App\profile::where('user_id',$user->id)->get()->first();
?>

@extends('layouts/app')

@section('content')
    @include('js/tinymc')

    <form method="POST" id = 'selfedit' role = "form" action="{{url()->current()}}">
        {{ csrf_field() }}

        @include("profile/layout/display_name",['object' => $user])

        @include("profile/layout/level",['object' => $user])

        @include("profile/layout/email",['object' => $user])

        @include("profile/layout/real_name",['object' => $profile])

        @include("profile/layout/bio",['object' => $profile])

        @include("profile/layout/location",['object' => $user])

        @include("profile.layout.birthday",['object' => $profile])

        @include("profile/layout/site",['object' => $profile])

        @include("profile/layout/github",['object' => $profile])

        @include("profile/layout/comment_footer",['object' => $user])

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>

@endsection