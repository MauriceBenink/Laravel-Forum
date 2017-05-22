@extends('layouts/app')
<?php Auth::user()->id==$user->id?$reqlevel=0:$reqlevel=profileEditLevel() ?>
@section('content')
    <form action="{{url('specialPermission')}}" method="POST">
    {{ csrf_field() }}

        <div class="page">
            Special Permissions page for UserGroup {{$groupname}}
        </div><br>

        Users in group

        Permissions


    </form>
    @endsection