@extends('layouts.message')

@section('message')
You are logged in! <br>
Welcome {{Auth::user()->display_name}}
    {{\App\main_topics::killme(\App\main_topics::all()->where('id',3)->first())}}
    @endsection