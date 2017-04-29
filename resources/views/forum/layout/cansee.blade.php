<div class="form-group{{ $errors->has('cansee') ? ' has-error' : '' }}">

<label for="cansee">Who can see this Comment</label>
<select name="cansee" id="cansee">
    <option value="0">Everyone</option>
    @foreach(\Illuminate\Support\Facades\DB::table('levels')->get()->all() as $tier)
        @if(\Illuminate\Support\Facades\Auth::user()->level >= $tier->level)
        <option value="{{$tier->level}}">{{$tier->name}}</option>
        @endif
        @endforeach
</select>

@if ($errors->has('cansee'))
    <span class="help-block">
        <strong>{{ $errors->first('cansee') }}</strong>
    </span>
@endif
</div>