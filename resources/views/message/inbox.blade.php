@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    @include('message/layout/list',['object' => $inbox])

    <form action="{{url('message')}}">
        <input type="submit" value = "back to menu">
    </form>

@endsection