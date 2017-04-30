<?php
$level = min_mod_level();
?>

@extends('layouts/app')

@section('content')
    @include('js/tinymc')
    <form method="POST" id = 'editcomment' role = "form" action="{{route('editComment',[$maintopic,$subtopic,$post->first()->id,$comment->id])}}">
        {{ csrf_field() }}
        @if(auth_level($level))
            @include('forum/layout/edit/author',['object'=> $comment])
            @endif
        @include('forum/layout/edit/title',['object' => $comment,'placeholder' => 'Optional!'])

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="content" class="col-md-4 control-label">Content</label>

            <div class="col-md-6">
                <textarea id="commentContent" class="form-control mce" name="commentContent" autofocus>{!! $comment->content !!}</textarea>

                @if ($errors->has('commentContent'))
                    <span class="help-block">
                        <strong>{{ $errors->first('commentContent') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        @if(auth_level($level))
            @include('forum/layout/edit/upper',['object'=> $comment])
        @endif

        @if(auth_level($level))
            @include('forum/layout/edit/priority',['object' => $comment])
            @include('forum/layout/edit/rating',['object' => $comment])
            @endif
        @include('forum/layout/edit/cansee',['object' => $comment])
        @if(auth_level($level))
            @include('forum/layout/edit/canedit',['object' => $comment])
            @endif
        @if(user_edit_permission($comment))
            @include ("forum/layout/edit/specialperm",['object' => $comment])
        @endif
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>


@endsection