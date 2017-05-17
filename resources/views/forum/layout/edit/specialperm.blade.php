<?php

$data = \Illuminate\Support\Facades\DB::table('class_link_tables')->where(class_basename($object)."_id",$object->id)->orderBy('permission','desc')->get();
$Gdata = \Illuminate\Support\Facades\DB::table('class_link_tables')->whereNotNull('group_name')->orderBy('group_name','desc')->get();
if(!is_null($object->author)){
    $authorid = $object->author->id;
}else{
    $authorid = 'abc';
}
?>
<div class="form-group{{ $errors->has('specialperm') ? ' has-error' : '' }}">
    <label for="specialperm"> special permissions </label>
    <!-- make a decend container and make this scrollable -->
        <label>Users</label>
        @foreach(\Illuminate\Support\Facades\DB::table('users')->orderBy('display_name','asc')->get()->all() as $user)
            @if($user->id != $authorid && \Illuminate\Support\Facades\Auth::user()->id != $user->id)
                <?php $datat = $data->where('user_id',$user->id) ?>
                @if(!empty($datat->all()))
                    @if($datat->first()->permission)
                    <input type = "checkbox" name="specialperm0[user][]" value="{{$user->id}}">
                    <input type = "checkbox" name="specialperm1[user][]" value="{{$user->id}}"checked>{{$user->display_name}}
                    @else
                    <input type = "checkbox" name="specialperm0[user][]" value="{{$user->id}}"checked>
                    <input type = "checkbox" name="specialperm1[user][]" value="{{$user->id}}">{{$user->display_name}}
                @endif
            @else
                <input type = "checkbox" name="specialperm0[user][]" value="{{$user->id}}">
                <input type = "checkbox" name="specialperm1[user][]" value="{{$user->id}}">{{$user->display_name}}
                    @endif
            @endif
        @endforeach

    <label>User Groups</label>
    @foreach($Gdata->where('user_group_id','<>',null)->all() as $group)
        @if(!empty($group))
            <?php $datat =$data->where('user_group_id',$group->user_group_id); ?>
            @if(!empty($datat->all()))
                @if($datat->first()->permission)
                    <input type="checkbox" name="specialperm0[usergroup][]" value="{{$group->user_group_id}}">
                    <input type="checkbox" name="specialperm1[usergroup][]" value="{{$group->user_group_id}}"checked>{{$group->group_name}}
                    @else
                    <input type="checkbox" name="specialperm0[usergroup][]" value="{{$group->user_group_id}}"checked>
                    <input type="checkbox" name="specialperm1[usergroup][]" value="{{$group->user_group_id}}">{{$group->group_name}}
                    @endif
                @else
        <input type="checkbox" name="specialperm0[usergroup][]" value="{{$group->user_group_id}}">
        <input type="checkbox" name="specialperm1[usergroup][]" value="{{$group->user_group_id}}">{{$group->group_name}}
                @endif
        @endif
        @endforeach
    <label>Content Groups</label>
    @foreach($Gdata->where('content_group_id','<>',null)->all() as $group)
        <?php $datat = $data->where('content_group_id',$group->content_group_id); ?>
        @if(!empty($group))
            @if(!empty($datat->all()))
                @if($datat->first()->permission)
                    <input type="checkbox" name="specialperm0[contgroup][]" value="{{$group->content_group_id}}">
                    <input type="checkbox" name="specialperm1[contgroup][]" value="{{$group->content_group_id}}"checked>{{$group->group_name}}
                @else
                    <input type="checkbox" name="specialperm0[contgroup][]" value="{{$group->content_group_id}}"checked>
                    <input type="checkbox" name="specialperm1[contgroup][]" value="{{$group->content_group_id}}">{{$group->group_name}}
                @endif
            @else
                <input type="checkbox" name="specialperm0[contgroup][]" value="{{$group->content_group_id}}">
                <input type="checkbox" name="specialperm1[contgroup][]" value="{{$group->content_group_id}}">{{$group->group_name}}
            @endif
        @endif
    @endforeach

    @include('error/inputError',['type' => 'specialperm'])

</div>