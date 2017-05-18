<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
    <label for="location" class="col-md-4 control-label">Location</label>

    <div class="col-md-6">
        <input id="location" type="text" class="form-control" name="location" value="{{ isset($object->location)&&!is_null($object->location)?$object->location:old('location')}}" autofocus>
        @if ($errors->has('location'))
            <span class="help-block">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
        @endif
    </div>
</div>
@include('error/inputError',['type' => 'location'])