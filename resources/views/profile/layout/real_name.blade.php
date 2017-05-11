<div class="form-group{{ $errors->has('real_name') ? ' has-error' : '' }}">
    <label for="real_name" class="col-md-4 control-label">Real name</label>

    <div class="col-md-6">
        <input id="real_name" type="text" class="form-control" name="real_name" value="{{ isset($object->name)&&!is_null($object->name)?$object->name:''}}" autofocus>
        @if ($errors->has('real_name'))
            <span class="help-block">
                        <strong>{{ $errors->first('real_name') }}</strong>
                    </span>
        @endif
    </div>
</div>
@if ($errors->has('real_name'))
    <span class="help-block">
        <strong>{{ $errors->first('real_name') }}</strong>
    </span>
@endif