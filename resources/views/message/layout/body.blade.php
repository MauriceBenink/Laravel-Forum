<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label for="title" class="col-md-4 control-label">Title</label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control" name="title" value="{{ $type=='reply'?'RE: '.$message->subject:old('title') }}" autofocus>

        @if ($errors->has('title'))
            <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
        @endif
    </div>
</div>
<br>
<br>
@include('js/tinymc')
<div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
    <label for="message" class="col-md-4 control-label">Message</label>
    <textarea id="message" class="form-control mce" name="message" autofocus>{!! old('message') !!}</textarea>
    @if ($errors->has('message'))
        <span class="help-block">
                    <strong>{{ $errors->first('message') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <div class="col-md-8 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            Send
        </button>
    </div>
</div>