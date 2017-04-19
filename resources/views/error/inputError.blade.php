@if ($errors->has($type))
    <span class="help-block">
        <strong>{{ $errors->first($type) }}</strong>
    </span>
@endif