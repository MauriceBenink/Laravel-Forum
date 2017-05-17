@extends('layouts.app')
@section('content')
    @if(session('returnError'))
        <div class="alert alert-danger">
            {{ session('returnError') }}
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('login_name') ? ' has-error' : '' }}">
                            <label for="login_name" class="col-md-4 control-label">login name</label>

                            <div class="col-md-6">
                                <input id="login_name" type="text" class="form-control" name="login_name" value="{{ old('login_name') }}" required autofocus>

                                @include('error/inputError',['type' => 'login_name'])
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @include('error/inputError',['type' => 'password'])
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('forgot.pass') }}">
                                    Forgot Your Password?
                                </a>
                                <a class="btn btn-link" href="{{ route('forgot.username') }}">
                                    Forgot Your Username?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
