<div class="form-group{{ $errors->has('cansee') ? ' has-error' : '' }}">

<label for="cansee">Who can see this Comment</label>
<select name="cansee" id="cansee">
    <option value="0">Everyone</option>
    <option value="1">All users</option>
    @if(\Illuminate\Support\Facades\Auth::user()->level > 2)
    <option value="3">Regular users</option>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user()->level > 4)
    <option value="5">Experianced users</option>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user()->level > 5)
    <option value="6">Moderators</option>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user()->level > 7)
    <option value="8">Admins</option>
    @endif
</select>

@if ($errors->has('cansee'))
    <span class="help-block">
        <strong>{{ $errors->first('cansee') }}</strong>
    </span>
@endif
</div>