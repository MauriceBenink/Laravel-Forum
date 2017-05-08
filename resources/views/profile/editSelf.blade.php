<?php
$auth = \Illuminate\Support\Facades\Auth::user();
$user = \App\User::where('user_id',$auth->id);
?>

@extends('layouts/app')

@section('content')
    @include('js/tinymc')

    <form method="POST" id = 'selfedit' role = "form" action="{{url()->current()}}">
        {{ csrf_field() }}
        <input type="file" name="file" id="file">

        <div class="form-group{{ $errors->has('real_name') ? ' has-error' : '' }}">
            <label for="real_name" class="col-md-4 control-label">Real name</label>

            <div class="col-md-6">
                <input id="real_name" type="text" class="form-control" name="real_name" value="{{ isset($user->name)?$user->name:''}}" autofocus>
                @if ($errors->has('real_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('real_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
            <label for="bio" class="col-md-4 control-label">BIO</label>

            <div class="col-md-6">
                <textarea id="bio" class="form-control mce" name="bio" autofocus>{!! isset($user->bio)?$user->bio:'' !!}</textarea>
                @if ($errors->has('bio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
            <label for="location" class="col-md-4 control-label">Location</label>

            <div class="col-md-6">
                <input id="location" type="text" class="form-control" name="location" value="{{ isset($user->location)?$user->location:''}}" autofocus>
                @if ($errors->has('location'))
                    <span class="help-block">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('bday') ? ' has-error' : '' }}">
            <label for="bday" class="col-md-4 control-label">Birth-Day</label>

            <div class="col-md-6">
                <input id="bday" type="date" class="form-control" name="bday" value="{{ isset($user->bday)?$user->bday:''}}" autofocus>
                @if ($errors->has('bday'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bday') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}">
            <label for="site" class="col-md-4 control-label">Site</label>

            <div class="col-md-6">
                <input id="site" type="text" class="form-control" name="site" value="{{ isset($user->site)?$user->site:''}}" autofocus>
                @if ($errors->has('site'))
                    <span class="help-block">
                        <strong>{{ $errors->first('site') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('github') ? ' has-error' : '' }}">
            <label for="github" class="col-md-4 control-label">GitHub</label>

            <div class="col-md-6">
                <input id="github" type="text" class="form-control" name="github" value="{{ isset($user->site)?$user->site:''}}" autofocus>
                @if ($errors->has('github'))
                    <span class="help-block">
                        <strong>{{ $errors->first('github') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('footer') ? ' has-error' : '' }}">
            <label for="footer" class="col-md-4 control-label">Comment Footer</label>

            <div class="col-md-6">
                <textarea id="footer" class="form-control mce" name="footer" autofocus>{!! isset($auth->comment_footer)?$auth->comment_footer:'' !!}</textarea>
                @if ($errors->has('footer'))
                    <span class="help-block">
                        <strong>{{ $errors->first('footer') }}</strong>
                    </span>
                @endif
            </div>
        </div>

    </form>

    @endsection