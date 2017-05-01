<?php
$level = subtopiclevel();
?>

@extends('layouts/app')

@section('content')
    @include('js/tinymc')
    <form method="POST" id = 'editSubTopic' role = "form" action="{{route('editSubTopic',[$maintopic,$subtopic])}}">
    {{ csrf_field() }}
    @if(auth_level($level))
        @include('forum/layout/edit/author',['object' => $subtopic])
    @endif
    @include('forum/layout/edit/title',['object' => $subtopic])
    @include('forum/layout/edit/description',['object' => $subtopic])
    @if(auth_level($level))
        @include('forum/layout/edit/upper',['object' => $subtopic])
        @include('forum/layout/edit/priority',['object' => $subtopic])
        @endif
    @include('forum/layout/edit/cansee',['object' => $subtopic])
    @if(auth_level($level))
        @include('forum/layout/edit/canedit',['object' => $subtopic])
    @endif
        @include ("forum/layout/edit/specialperm",['object' => $subtopic])
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>
@endsection