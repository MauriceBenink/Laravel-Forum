@extends('layouts/app')

@section('content')
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    @include('error/inputError',['type' => 'name'])
    @include('error/inputError',['type' => 'level'])
    @include('error/inputError',['type' => 'staff'])

@foreach($levels as $level)
    <form action="{{url('adminPanel/levels')}}" method="post">
        {{csrf_field()}}
        <input type="text" value="{{$level->name}}" name="name">

        @if($level->level==1||$level->level==2)
            <input type="number" value="{{$level->level}}" name="level" disabled>
            <input type="hidden" value="{{$level->level}}" name="level">
        @else
            <input type="number" value="{{$level->level}}" name="level">
        @endif

        @if($level->is_staff)
            <input type="checkbox" name = 'staff' checked>
        @else
            <input type="checkbox" name = 'staff'>
        @endif

        <input type="hidden" value="{{$level->id}}" name ="id">
        <input type="submit" value="Change">
        <input type="submit" value = "Delete" name = "delete">
    </form>
@endforeach
    New Rank
    <form action="{{url('adminPanel/levels')}}" method="post">
    {{csrf_field()}}
        <input type="text" placeholder="Name of the rank" name="name">
        <input type="number" name="level">
        <input type="checkbox" name = 'staff'>
        <input type="submit" value="Add">
    </form>
    <hr>
    <form action="{{url('adminPanel')}}">
        <input type="submit" value ="return to panel">
    </form>
@endsection