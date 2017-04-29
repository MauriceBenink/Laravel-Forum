
<div class="form-group{{ $errors->has('specialperm') ? ' has-error' : '' }}">
    <label for="specialperm"> special permissions </label>
    <!-- make a decend container and make this scrollable -->
        <label>Users</label>
        @foreach(\Illuminate\Support\Facades\DB::table('users')->orderBy('display_name','asc')->get()->all() as $user)
            @if($user->id != $comment->author->id)
                @if(!empty(\Illuminate\Support\Facades\DB::table('class_link_tables')->where('user_id',$user->id)->where("comments_id",$comment->id)->get()->all()))
                    @if(\Illuminate\Support\Facades\DB::table('class_link_tables')->where('user_id',$user->id)->where("comments_id",$comment->id)->orderBy('permission','desc')->get()->first()->permission)
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
    @foreach(\Illuminate\Support\Facades\DB::table('class_link_tables')->whereNotNull('user_group_id')->whereNotNull('group_name')->orderBy('group_name','desc')->get()->all() as $group)
        @if(!empty($group))
            @if(!empty(\Illuminate\Support\Facades\DB::table('class_link_tables')->where('user_group_id',$group->user_group_id)->where("comments_id",$comment->id)->get()->all()))
                @if(\Illuminate\Support\Facades\DB::table('class_link_tables')->where('user_group_id',$group->user_group_id)->where("comments_id",$comment->id)->orderBy('permission','desc')->get()->first()->permission)
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
    @foreach(\Illuminate\Support\Facades\DB::table('class_link_tables')->whereNotNull('content_group_id')->whereNotNull('group_name')->orderBy('group_name','desc')->get()->all() as $group)

        @if(!empty($group))
            @if(!empty(\Illuminate\Support\Facades\DB::table('class_link_tables')->where('content_group_id',$group->content_group_id)->where("comments_id",$comment->id)->get()->all()))
                @if(\Illuminate\Support\Facades\DB::table('class_link_tables')->where('content_group_id',$group->content_group_id)->where("comments_id",$comment->id)->orderBy('permission','desc')->get()->first()->permission)
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

</div>