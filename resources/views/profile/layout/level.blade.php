<?php $tiers = \Illuminate\Support\Facades\DB::table('levels')->get()->all() ?>
<div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
    <label for="level" >Level</label>
        <select name="level" id="level">
            <?php $level = \Illuminate\Support\Facades\Auth::user()->level ?>
            @foreach($tiers as $tier)
                @if($level >= $tier->level &&!is_null($tier->level)&&!is_null($tier->level))
                    <option value="{{$tier->level}}">{{$tier->name}}</option>
                @endif
            @endforeach
    </select>
</div>
@if ($errors->has('level'))
    <span class="help-block">
        <strong>{{ $errors->first('level') }}</strong>
    </span>
@endif