<div class="form-group{{ $errors->has('cansee') ? ' has-error' : '' }}">
    @if(isset($newname))
        <label for="canedit">Who can see this {{$newname}}</label>
    @else
        <label for="canedit">Who can see this {{prittyName($object)}}</label>
    @endif
<select name="cansee" id="cansee">
    <option value="0">Everyone</option>
    <?php $level = \Illuminate\Support\Facades\Auth::user()->level ?>
    @foreach(\Illuminate\Support\Facades\DB::table('levels')->get()->all() as $tier)
        @if($level >= $tier->level &&!is_null($tier->level)&&!is_null($tier->level))
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