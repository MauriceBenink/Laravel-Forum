@extends('layouts/app')
<?php Auth::user()->id==$user->id?$reqlevel=0:$reqlevel=profileEditLevel() ?>
@section('content')
    <form action="{{url('specialPermission')}}" method="POST">
        {{ csrf_field() }}
    <div class="page">
        Special Permissions page for {{$user->display_name}}
    </div><br>

    <ul>
    <li class="user title">
        <h4>
            <a href="{{url("profile/show/$user->display_name")}}">{{$user->display_name}}</a>
            </h4>
        <ul>
            @foreach($perms as $perm)
                @include('specialperm/layout/show',['object' => $perm])
            @endforeach
        </ul>
    </li>

    @foreach($perms as $perm)
        @if(!is_null($perm->user_group_id))
            <li class="user_group title">
                <h4>
                    @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
                        <input type="submit" value = "Leave" name = 'delete' onclick="return $(this).val('{{$perm->id*2}}')">
                    @endif
                    <?php $name = App\class_link_table::where('user_group_id',$perm->user_group)->whereNotNull('group_name')->get()->first()->group_name ?>
                        <a href="{{url("group/specialperm/$name")}}">{{$name}}</a>
                </h4>
                <?php $reqlevel = profileEditLevel() ?>
                <ul>
                    @foreach($perm->user_group_id as $group)

                        @include('specialperm/layout/content_group',['object' => $group])

                        @include('specialperm/layout/show',['object' => $group])

                    @endforeach
                </ul>
            </li>
            <br>

        @else
                @include('specialperm/layout/content_group',['object' => $perm])
        @endif
    @endforeach
    </ul>
    </form>
    @endsection