<div class="form-group{{ $errors->has('canedit') ? ' has-error' : '' }}">

    <label for="canedit">Who can edit this Comment</label>
    <select name="canedit" id="canedit">
        @foreach(\Illuminate\Support\Facades\DB::table('levels')->where('is_staff',1)->get()->all() as $tier)
            @if(\Illuminate\Support\Facades\Auth::user()->level >= $tier->level)
                <option value="{{$tier->level}}">{{$tier->name}}</option>
            @endif
        @endforeach
    </select>

    @if ($errors->has('canedit'))
        <span class="help-block">
        <strong>{{ $errors->first('canedit') }}</strong>
    </span>
    @endif
</div>