@extends('layouts/app')

@section('content')

    <div class="container">
        <div class="alert alert-danger">
            If you change your Email Adress you will have to Validate it again before being able to Post/Comment things again!!!!
        </div>
    </div>
    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    <form method="POST" id = 'Change' role = "form" action="{{url('profile/email')}}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
            <label for="login" class="col-md-4 control-label">Login Name</label>

            <div class="col-md-6">
                <input id="login" type="text" class="form-control" name="login" required>

                @include('error/inputError',['type' => 'login'])
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @include('error/inputError',['type' => 'password'])
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">New Email</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" required>

                @include('error/inputError',['type' => 'email'])
            </div>
        </div>

        <div class="form-group">
            <label for="email-confirm" class="col-md-4 control-label">Confirm New Email</label>

            <div class="col-md-6">
                <input id="email-confirm" type="email" class="form-control" name="email_confirmation" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Change
                </button>
            </div>
        </div>

    </form>

@endsection