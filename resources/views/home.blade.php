@extends('layouts.message')

@section('message')
You are logged in! <br>
Welcome {{Auth::user()->display_name}}


    @endsection