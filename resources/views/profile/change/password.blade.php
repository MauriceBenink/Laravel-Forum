@extends('layouts/app')

@section('content')

<form method="POST" id = 'Change' role = "form" action="{{url('profile/password')}}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
        <label for="login" class="col-md-4 control-label">Login Name</label>

        <div class="col-md-6">
            <input id="login" type="text" class="form-control" name="login" required>

            @include('error/inputError',['type' => 'login'])
        </div>
    </div>

    <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
        <label for="oldpassword" class="col-md-4 control-label">Old Password</label>

        <div class="col-md-6">
            <input id="oldpassword" type="password" class="form-control" name="oldpassword" required>

            @include('error/inputError',['type' => 'oldpassword'])
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-4 control-label">New Password</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" required>

            @include('error/inputError',['type' => 'password'])
        </div>
    </div>

    <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label">Confirm New Password</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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