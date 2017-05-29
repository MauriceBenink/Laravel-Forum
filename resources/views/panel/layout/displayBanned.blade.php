<li>
    <?php $object = $object[0] ?>
    <form action="{{url('adminPanel/bannedPosts')}}" method = "POST">
        {{csrf_field()}}
        <input type="submit" value = "Unban this {{prittyName($object)}}">
        <input type="hidden" name = "{{class_basename($object)}}" value = "{{$object->id}}">
    </form>
    <ul>
        <li><b>Name : </b>{{!is_null($object->name)?$object->name:'not set'}}</li>
        @if(!is_null($object->description))
            <li><b>Description : </b>{!!$object->description!!}</li>
        @endif
        @if(!is_null($object->content))
            <li><b>Content : </b>{!!$object->content!!}</li>
        @endif
        <?php $author = $object->author; ?>
        @if(!is_null($author))
        <li><b>Author : </b><a href="{{url("profile/show/$author->display_name")}}">{{$author->display_name}}</a>, Level : {{$author->levelName->name}}</li>
        @endif
        <?php $banner = $object->bannedBy ?>
        <li><b>Banned By : </b><a href="{{url("profile/show/$banner->display_name")}}">{{$banner->display_name}}</a>, Level : {{$banner->levelName->name}}</li>
        <li><b>Reason for Ban : </b>{{$object->banned_reason}}</li>
    </ul>
</li>