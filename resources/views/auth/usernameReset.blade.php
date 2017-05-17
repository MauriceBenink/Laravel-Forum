@extends('layouts/app')

@section('content')

    @if(session('returnError'))
        <div class="container">
            <div class="alert alert-danger">
                {{ session('returnError') }}
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Username Reset</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('validate/username') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('hash') ? ' has-error' : '' }}">
                                <label for="hash" class="col-md-4 control-label">Code</label>

                                <div class="col-md-6">
                                    <input id="hash" type="text" class="form-control" value = "{{$hash or old('hash')}}" name="hash" required>

                                    @include('error/inputError',['type' => 'hash'])
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('login_name') ? ' has-error' : '' }}">
                                <label for="login_name" class="col-md-4 control-label">Login name</label>

                                <div class="col-md-6">
                                    <input id="login_name" type="text" class="form-control" name="login_name" required autofocus>

                                    @include('error/inputError',['type' => 'login_name'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="login_name-confirm" class="col-md-4 control-label">Confirm Login name</label>

                                <div class="col-md-6">
                                    <input id="login_name-confirm" type="text" class="form-control" name="login_name_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Reset
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