<?php
$post = \App\posts::all()->where('id',$post)->first();
?>

@extends('layouts/app')
@section('content')
    @if(!is_null($comments->first()))
    @include('forum/layout/nav',['type' => 'comment','item' => $comments->first()])
    <div class="checkhereplsjavascript">
        <div class="container">
        @if(user_edit_permission($post))
            @include('forum/layout/toolbar',['type' => 'post'])
        @endif
        @include('forum/layout/commentpost',['post' => $post,'comment' => 'value'])
        <hr>
        </div>
    </div>
    <br>
    @foreach($comments as $comment)
        @if(user_permission($comment))
            <div class="container">
                @if(user_edit_permission($comment))
                    @include('forum/layout/toolbar',['type' => 'comment'])
                @endif

                @include('forum/layout/comment',['comment' => $comment])
            </div>

        @endif
    @endforeach
        @else
        @include('forum/layout/nothingHere',['type' =>'comment','back' => ['main' => $maintopic, "sub" => $subtopic ,"post" => $post]])
    @endif
    @include('js/myjavascript');
@endsection