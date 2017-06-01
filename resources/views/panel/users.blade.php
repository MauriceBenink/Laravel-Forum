@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    Users : <form action="{{url('adminPanel/Users')}}">
        <input type="submit" value="Show">
        <select name="options" id="id">
            <option value="{{!is_null($rank)?$rank:''}}">{{!is_null($rank)?$rank:''}}</option>
            <option value="">All</option>
            @foreach(\App\level::get()->all() as $level)
                @if(!is_null($rank))
                    @if($rank != $level->name)
                        <option value="{{$level->name}}">{{$level->name}}</option>
                    @endif
                @else
                    <option value="{{$level->name}}">{{$level->name}}</option>
                @endif
            @endforeach
        </select>
    </form>
    <hr>

    <form method="POST">
        {{csrf_field()}}
        <script>
            function ban(object,person){
                reason = prompt('Reason for ban');
                if(!(reason == null||reason == '')){
                    return $(object).append($($('<input>').attr('name','reason').val(reason))).append($($('<input>').attr('name','user').val(person)));
                }else{
                    return false;
                }}

            function unban(object,person){
                if(confirm('are you sure you want to unban this person ?')){
                    return $(object).append($($('<input>').attr('name','unban')).val('unban')).append(($($('<input>').attr('name','user')).val(person)));
                }else{
                    return false;
                }
            }
        </script>
        <ul>
            @foreach($users as $user)
                <li>
                    <a href="{{url("profile/show/$user->display_name")}}">{{$user->display_name}}</a> {{$user->levelName->name}}
                    @if(Illuminate\Support\Facades\Auth::user()->level > $user->level)
                       @if(is_null($user->banned_by))
                            <input type="submit" value = "ban" onclick ="return ban(this,'{{$user->display_name}}')">
                       @else
                            <input type="submit" value = "unban" onclick = "return unban(this,'{{$user->display_name}}')">
                       @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </form>
    <hr>

    <form action="{{url('adminPanel')}}">
        <input type="submit" value ="return to panel">
    </form>
@endsection