@extends('layouts/app')
@section('content')
    @if(!is_null($subtopics->first()))
    @include('forum/layout/nav',['type' => 'subtopics','item' => $subtopics->first()])
    <div class="checkhereplsjavascript">
    @foreach($subtopics as $subtopic)
        @if(user_permission($subtopic))
            <div class="container">
                @if(user_edit_permission($subtopic))
                    @include('forum/layout/toolbar',['type' => 'subtopic'])
                @endif

                @include('forum/layout/subtopic',['subtopic' => $subtopic])
            </div>

        @endif
    @endforeach
    </div>

    @else
        @include('forum/layout/nothingHere',['type' =>'subtopic','back' => 'main'])
    @endif
    @include('js/myjavascript')

@endsection