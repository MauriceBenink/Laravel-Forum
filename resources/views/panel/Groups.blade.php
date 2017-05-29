@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif
{{$type}} Group
    <?php $typename = $type=='User'?'userGroup':'contentGroup'; ?>

    <form action="{{url('new/specialperm')}}" METHOD="POST">
        {{ csrf_field() }}
        <input type="submit" value="Make New {{$type}} Group" name="newGroup" onclick="return make(this)">
        <script>
            function make(object){
                name = prompt('Name of the group');
                if(!(name == null||name == '')){
                    return $(object).append($($('<input>').attr('name','contentGroup').val(name)));
                }else{
                    return false;
                }}
        </script>
    </form>
    <hr>
    <ul>
<?php $typename = $type=='User'?'group':'content'; ?>
    @foreach($groups as $group)

        <li><a href="{{url("$typename/specialperm/$group->group_name")}}">{{$group->group_name}}</a></li>

    @endforeach
    </ul>
    <hr>

    <form action="{{url('adminPanel')}}">
        <input type="submit" value ="return to panel">
    </form>

@endsection