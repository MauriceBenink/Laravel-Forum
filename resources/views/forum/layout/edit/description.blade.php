<?php
 if(!isset($placeholer)){
    $placeholder = '';
 }
?>

<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="col-md-4 control-label">Description</label>

    <div class="col-md-6">
        <input id="description" type="text" class="form-control" placeholder = "{{$placeholder}}" name="description" value="{{ $object->description }}" autofocus>

        @if ($errors->has('description'))
            <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
        @endif
    </div>
</div>