@extends('layouts/app')
<?php $reqlevel = profileEditLevel(); ?>
@section('content')
    @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
        <form action="{{url('new/specialperm')}}" METHOD="POST">
            {{ csrf_field() }}
            <input type="submit" value="Make New User Group" name="newGroup" onclick="return make(this)">
            <script>
                function make(object){
                    name = prompt('Name of the group');
                    if(!(name == null||name == '')){
                        return $(object).append($($('<input>').attr('name','userGroup').val(name)));
                    }else{
                        return false;
                    }}
            </script>
        </form>
    @endif

    <form action="{{url('specialPermission')}}" method="POST">
    {{ csrf_field() }}

        <div class="page">
            Special Permissions page for UserGroup {{$groupname}}
        </div><br>

        <ul class="members">
            <h4>Members :</h4>
            @foreach($people as $member)
                @include('specialperm/layout/member',['object' => $member])
            @endforeach
        </ul>

        <ul class = 'permissions'>
            <h4>
                @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
                    <input type="submit" value = "Destory Group" name = 'remove' onclick="return $(this).val('group||{{$group[0]->user_group_id}}')">
                @endif

                <a href="{{url("group/specialperm/$groupname")}}">{{$groupname}}</a>
            </h4>
            @foreach($group as $solo)

                @include('specialperm/layout/show',['object' => $solo])

                @include('specialperm/layout/content_group',['object' => $solo])

            @endforeach
        </ul>


    </form>
    @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
        <form action="{{url_add('add')}}">
            {{ csrf_field() }}
            <button>Add to this Group</button>
        </form>
    @endif
    @endsection