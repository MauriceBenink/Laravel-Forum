<?php
    $path = "\\App\\".class_basename($object->up);
?>


<div class="form-group{{ $errors->has('upper') ? ' has-error' : '' }}">

    <label for="upper">Change {{prittyName($object)}} location</label>
    <select name="upper" id="upper">
        <option value="{{$object->upper_level_id}}">{{$object->up->name}}</option>
        @foreach($path::all()->where('id','=',$object->upper_level_id) as $item)
            @if($item->id != $object->upper_level_id)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endif
        @endforeach
        @foreach($path::all()->where('id','<>',$object->upper_level_id) as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
    </select>

    @if ($errors->has('author'))
        <span class="help-block">
        <strong>{{ $errors->first('author') }}</strong>
    </span>
    @endif
</div>