<div class="form-group{{ $errors->has('canedit') ? ' has-error' : '' }}">

    <label for="canedit">Who can edit this Comment</label>
    <select name="canedit" id="canedit">
        @if(\Illuminate\Support\Facades\Auth::user()->level > 5)
            <option value="6">Moderators</option>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->level > 7)
            <option value="8">Admins</option>
        @endif
    </select>

    @if ($errors->has('canedit'))
        <span class="help-block">
        <strong>{{ $errors->first('canedit') }}</strong>
    </span>
    @endif
</div>