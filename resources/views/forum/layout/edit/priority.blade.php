<div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
    <label for="priority" class="col-md-4 control-label">Priority</label>

    <div class="col-md-6">
        <input id="priority" type="number" class="form-control" name="priority" value="{{ $object->priority }}" autofocus>

        @if ($errors->has('priority'))
            <span class="help-block">
                        <strong>{{ $errors->first('priority') }}</strong>
                    </span>
        @endif
    </div>
</div>