<div class="form-group{{ $errors->has('bday') ? ' has-error' : '' }}">
    <label for="bday" class="col-md-4 control-label">Birth-Day</label>
    <div class="col-md-6">
        <input id="bday" type="date" class="form-control" name="bday" value="{{ isset($object->birthday)&&!is_null($object->birthday)? Carbon\Carbon::parse($object->birthday)->toDateString():old('bday')}}" autofocus>
        @if ($errors->has('bday'))
            <span class="help-block">
                        <strong>{{ $errors->first('bday') }}</strong>
                    </span>
        @endif
    </div>
</div>
@include('error/inputError',['type' => 'bday'])