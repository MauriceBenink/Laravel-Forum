@extends('layouts/app')

@section('content')

    <form method="POST" id = 'Change' role = "form" action="{{url('profile/username')}}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('oldlogin') ? ' has-error' : '' }}">
            <label for="oldlogin" class="col-md-4 control-label">Old Login Name</label>

            <div class="col-md-6">
                <input id="oldlogin" type="text" class="form-control" name="oldlogin" required>

                @include('error/inputError',['type' => 'oldlogin'])
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @include('error/inputError',['type' => 'password'])
            </div>
        </div>

        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
            <label for="login" class="col-md-4 control-label">New Login Name</label>

            <div class="col-md-6">
                <input id="login" type="text" class="form-control" name="login" required>

                @include('error/inputError',['type' => 'login'])
            </div>
        </div>

        <div class="form-group">
            <label for="login-confirm" class="col-md-4 control-label">Confirm New Login Name</label>

            <div class="col-md-6">
                <input id="login-confirm" type="text" class="form-control" name="login_confirmation" required>
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