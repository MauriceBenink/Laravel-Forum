@extends('layouts/app')

@section("content")
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    <form action="{{url('message/send')}}" method="POST">
        {{csrf_field()}}
        <label for="to">TO : </label>
        <select name="to" id="to">
            @if(!is_null($link))
                <option value="{{$link}}">{{$link}}</option>
            @endif
            @foreach(App\User::all() as $user)
                @if($user->id != Auth::user()->id || $user->display_name == $link)
                    <option value="{{$user->display_name}}">{{$user->display_name}}</option>
                @endif
            @endforeach
        </select>

        @include('message/layout/body',['type' => 'send'])

    </form>
    
@endsection