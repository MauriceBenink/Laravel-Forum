@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    Banned Content :
    <hr>

    @foreach($holder as $items)
        @if(!empty($items))
            <div>{{prittyName($items[0])}}</div>
            <ul>
            @foreach($items as $item)
                @include('panel/layout/displayBanned',['object' => $items])
            @endforeach
            </ul>
        @endif
    <br>

    @endforeach
    <hr>
    <form action="{{url('adminPanel')}}">
        <input type="submit" value ="return to panel">
    </form>

@endsection