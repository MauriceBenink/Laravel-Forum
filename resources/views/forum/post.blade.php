@extends('layouts/app')

@section('content')
    @if(!is_null($posts->first()))

    @include('forum/layout/nav',['type' => 'posts'],['item' => $posts->first()])
    <div class="checkhereplsjavascript">
    @foreach($posts as $post)
        @if(user_permission($post))
            <div class="container">
                @if(user_edit_permission($post))
                    @include('forum/layout/toolbar',['type' => 'post'])
                @endif

                @include('forum/layout/post',['post' => $post])
            </div>

            @endif
    @endforeach
    </div>
    @else
        @include('forum/layout/nothingHere',['type' =>'post','back' => ['main' => $maintopic]])
    @endif
    @include('js/myjavascript')
@endsection