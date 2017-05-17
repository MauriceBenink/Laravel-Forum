<div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}">
    <label for="site" class="col-md-4 control-label">Site</label>

    <div class="col-md-6">
        <input id="site" type="text" class="form-control" name="site" value="{{ isset($object->site)&&!is_null($object->site)?$object->site:''}}" autofocus>
        @if ($errors->has('site'))
            <span class="help-block">
                        <strong>{{ $errors->first('site') }}</strong>
                    </span>
        @endif
    </div>
</div>
@include('error/inputError',['type' => 'site'])