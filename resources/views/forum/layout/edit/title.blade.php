<?php
if(!isset($placeholder)){
    $placeholder = '';
}
?>

<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label for="title" class="col-md-4 control-label">Title</label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control" placeholder = "{{$placeholder}}" name="title" value="{{ $object->name }}" autofocus>

        @include('error/inputError',['type' => 'title'])
    </div>
</div>