@extends("layouts/app")

@section('content')


    <form class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('login_name') ? ' has-error' : '' }}">
            <label for="login_name" class="col-md-4 control-label">Login name</label>

            <div class="col-md-6">
                <input id="login_name" type="text" class="form-control" name="login_name" value="{{ old('login_name') }}" required autofocus>

                @include('error/inputError',['type' => 'login_name'])
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">Email</label>

            <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @include('error/inputError',['type' => 'email'])
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>


    </form>
    @endsection