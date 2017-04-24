@extends('layouts/app')

@section('content')
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
        @endif

    @if(!is_null($maintopics->first()))
    @include('forum/layout/nav',['type' => 'maintopics'])
    @foreach($maintopics as $maintopic)
        @if(user_permission($maintopic))
            <div class="container checkhereplsjavascript">
                @if(user_edit_permission($maintopic))
                    @include('forum/layout/toolbar',['type' => 'maintopic'])
                @endif

                @include('forum/layout/maintopic',['maintopic' => $maintopic])
            </div>
        @endif

    @endforeach

    @else
        @include('forum/layout/nothingHere',['type' =>'maintopic'])
    @endif
    @include('js/myjavascript')
@endsection