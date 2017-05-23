@extends('layouts/app')
<?php $reqlevel=profileEditLevel() ?>
@section('content')
    @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
        <form action="{{url('new/specialperm')}}" METHOD="POST">
            {{ csrf_field() }}
            <input type="submit" value="Make New Content Group" name="newGroup" onclick="return make(this)">
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
    @endif

    <form action="{{url('specialPermission')}}" method="POST">
        {{ csrf_field() }}

        <div class="page">
            Special Permissions page for Content Group {{$groupname}}
        </div><br>

        <ul class="members">
            <h4>Poeple with accsess :</h4>
            Direct Accsess :
            @if(isset($people['direct']))
                @foreach($people['direct'] as $member)
                    @include('specialperm/layout/member',['object' => $member])
                @endforeach
                <?php unset($people['direct']); ?>
            @endif
            @if(count($people)>=1)
                Group Accsess :
                @foreach($people as $groupname => $usergroup)
                    <li class = 'User Group'>
                        <h4>
                            <a href="{{url("group/specialperm/$groupname")}}">{{$groupname}}</a>
                        </h4>
                        <ul>
                            @foreach($groupname as $member)
                                @include('specialperm/layout/member',['object' => $member])
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>

        <ul class="permissions">
            <h4>
                @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
                    <input type="submit" value = "Destory Content Group" name = 'remove' onclick="return $(this).val('content||{{$group[0]->user_group_id}}')">
                @endif

                <a href="{{url("content/specialperm/$groupname")}}">{{$groupname}}</a>
            </h4>
            @foreach($group as $solo)

                @include('specialperm/layout/show',['object' => $solo])

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