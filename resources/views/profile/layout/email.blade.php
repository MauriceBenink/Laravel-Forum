<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-md-4 control-label">Email</label>
    <div class="col-md-6">
        <input id="email" type="email" class="form-control" name="email" value="{{ isset($object->email)&&!is_null($object->email)? $object->email:''}}" autofocus>
        @if ($errors->has('email'))
            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
        @endif
    </div>
</div>
@include('error/inputError',['type' => 'email'])