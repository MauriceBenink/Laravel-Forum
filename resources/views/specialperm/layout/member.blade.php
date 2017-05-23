<?php $member = App\User::where('id',$object->user_id)->get()->first() ?>
<li class="member">
    @if( Illuminate\Support\Facades\Auth::user()->level >= $reqlevel|| Illuminate\Support\Facades\Auth::user()->id == $member->id)
        <input type="submit" value = "Leave" name = 'delete' onclick="return $(this).val('{{$object->id*2}}')">
    @endif
    <a href="{{url("profile/show/$member->display_name")}}">{{$member->display_name}}</a> Rank: {{$member->levelName->name}}
</li>