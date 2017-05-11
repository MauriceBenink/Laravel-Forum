<div class="form-group{{ $errors->has('footer') ? ' has-error' : '' }}">
    <label for="footer" class="col-md-4 control-label">Comment Footer</label>

    <div class="col-md-6">
        <textarea id="footer" class="form-control mce" name="footer" autofocus>{!! isset($object->comment_footer)&&!is_null($object->comment_footer)?$object->comment_footer:'' !!}</textarea>
        @if ($errors->has('footer'))
            <span class="help-block">
                        <strong>{{ $errors->first('footer') }}</strong>
                    </span>
        @endif
    </div>
</div>
@if ($errors->has('footer'))
    <span class="help-block">
        <strong>{{ $errors->first('footer') }}</strong>
    </span>
@endif