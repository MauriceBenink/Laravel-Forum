<div class="form-group{{ $errors->has('github') ? ' has-error' : '' }}">
    <label for="github" class="col-md-4 control-label">GitHub:<b style = font-size:10px;> https://github.com/<i style = color:red>copy paste this</i></b></label>

    <div class="col-md-6">
        <input id="github" type="text" class="form-control" name="github" value="{{ isset($object->github)&&!is_null($object->github)?$object->github:old('github')}}" autofocus>
        @if ($errors->has('github'))
            <span class="help-block">
                        <strong>{{ $errors->first('github') }}</strong>
                    </span>
        @endif
    </div>
</div>
@include('error/inputError',['type' => 'github'])