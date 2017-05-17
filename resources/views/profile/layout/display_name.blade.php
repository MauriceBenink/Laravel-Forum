<div class="form-group{{ $errors->has('displayname') ? ' has-error' : '' }}">
    <label for="displayname" class="col-md-4 control-label">Display Name</label>

    <div class="col-md-6">
        <input id="displayname" type="text" class="form-control" name="displayname" value="{{old('displayname') OR isset($object->display_name)&&!is_null($object->display_name)?$object->display_name:''}}" autofocus>
        @if ($errors->has('displayname'))
            <span class="help-block">
                        <strong>{{ $errors->first('displayname') }}</strong>
                    </span>
        @endif
    </div>
</div>
@include('error/inputError',['type' => 'displayname'])