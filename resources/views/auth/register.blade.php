@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
                            <label for="display_name" class="col-md-4 control-label">Display Name</label>

                            <div class="col-md-6">
                                <input id="display_name" type="text" class="form-control" name="display_name" value="{{ old('display_name') }}" required autofocus>

                                @if ($errors->has('display_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('display_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @include('error/inputError',['type' => 'email'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email-confirm" class="col-md-4 control-label">Confirm email</label>

                            <div class="col-md-6">
                                <input id="email-confirm" type="text" class="form-control" name="email_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('login_name') ? ' has-error' : '' }}">
                            <label for="login_name" class="col-md-4 control-label">login name</label>

                            <div class="col-md-6">
                                <input id="login_name" type="text" class="form-control" name="login_name"  required>

                                @include('error/inputError',['type' => 'login_name'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="login_name-confirm" class="col-md-4 control-label">Confirm login name</label>

                            <div class="col-md-6">
                                <input id="login_name-confirm" type="text" class="form-control" name="login_name_confirmation" required>
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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
