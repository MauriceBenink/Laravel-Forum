<div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
    <label for="bio" class="col-md-4 control-label">BIO</label>

    <div class="col-md-6">
        <textarea id="bio" class="form-control mce" name="bio" autofocus>{!! isset($object->bio)&&!is_null($object->bio)?$object->bio:'' !!}</textarea>
        @if ($errors->has('bio'))
            <span class="help-block">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
        @endif
    </div>
</div>
@if ($errors->has('bio'))
    <span class="help-block">
        <strong>{{ $errors->first('bio') }}</strong>
    </span>
@endif