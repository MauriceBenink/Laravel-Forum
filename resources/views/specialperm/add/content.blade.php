@extends('layouts/app')


@section('content')
    <form action="{{url('specialPermission/add')}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name ="info" value="{{$content[0]->content_group_id}}">
        <input type="hidden" name ="type" value="content">
    <ul><li style="list-style-type:none">Add to Content Group <input type="text" name="groupname" value="{{$name}}"> (you can change the name here)</li></ul>
    <br><br>
        <ul id="list-container" style="float:left">
            <li class = "main-list" style = "float:left;margin-left:10px;list-style-type:none">
                <ul class="users">
                    <li style="list-style-type: none">Users</li>
                    @foreach($users as $user)
                        <li style="list-style-type: none">
                            <input type="checkbox" name="add[user][]" value="{{$user->id}}">{{$user->display_name}}
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class = "main-list" style = "float:left;margin-left:10px;list-style-type:none">
                <ul class="user-group">
                    <li style="list-style-type: none">User Groups</li>
                    @if(!is_null($group))
                        @foreach($group as $solo)
                            <li style="list-style-type: none">
                                <input type="checkbox" name="add[group][]" value="{{$solo->user_group_id}}">{{$solo->group_name}}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>
@endsection