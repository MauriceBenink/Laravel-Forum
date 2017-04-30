<?php
    $level = min_mod_level();
?>

@extends('layouts/app')

@section('content')
    @include('js/tinymc')
    <form method="POST" id = 'editPost' role = "form" action="{{route('editPost',[$maintopic,$subtopic,$post->id])}}">
    {{ csrf_field() }}
    @if(auth_level($level))
        @include('forum/layout/edit/author',['object' => $post])
    @endif
        @include('forum/layout/edit/title',['object' => $post])
        @include('forum/layout/edit/description',['object' => $post])

        <div class="form-group{{ $errors->has('contentt') ? ' has-error' : '' }}">
            <label for="contentt" class="col-md-4 control-label">Content</label>

            <div class="col-md-6">
                <textarea id="contentt" class="form-control mce" name="contentt" autofocus>{!! $post->content !!}</textarea>

                @if ($errors->has('contentt'))
                    <span class="help-block">
                        <strong>{{ $errors->first('contentt') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        @if(auth_level($level))
            @include('forum/layout/edit/upper',['object' => $post])
        @endif

        @if(auth_level($level))
            @include('forum/layout/edit/priority',['object' => $post])
            @include('forum/layout/edit/rating',['object' => $post])
            @endif
        @include('forum/layout/edit/cansee',['object' => $post])
        @if(auth_level($level))
            @include('forum/layout/edit/canedit',['object' => $post])
        @endif
        @include ("forum/layout/edit/specialperm",['object' => $post])
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>
    @endsection