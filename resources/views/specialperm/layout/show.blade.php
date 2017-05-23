<?php
    if(!isset($url)){
        $url = App\Http\Controllers\urlInsert::class;
    }
?>

@if(!is_null($object->main_topics_id))
    <li class="maintopic">
        @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
            <input type="submit" value = "Delete" name = 'delete' onclick="return $(this).val('{{$object->id*2}}')">
        @endif
            <a href="{{url('forum')}}"><label for="maintopic">Main Topic :</label></a> {{App\main_topics::where('id',$object->main_topics_id)->get()->first()->name}} <b>-></b>  {{$object->permision==0?"Vieuw Permission":"Edit Permission"}}
    </li>


@elseif(!is_null($object->sub_topics_id))
    <li class="subtopic">
        @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
            <input type="submit" value = "Delete" name = 'delete' onclick="return $(this).val('{{$object->id*2}}')">
        @endif
        <?php $sub = App\sub_topics::where('id',$object->sub_topics_id)->get()->first() ?>
            <a href="{{url($url::geturl($sub))}}"><label for="subtopic">Sub Topic :</label></a> {{$sub->name}} <b>-></b>  {{$object->permision==0?"Vieuw Permission":"Edit Permission"}}
    </li>

@elseif(!is_null($object->posts_id))
    <li class="post">
        @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
            <input type="submit" value = "Delete" name = 'delete' onclick="return $(this).val('{{$object->id*2}}')">
        @endif
        <?php $post = App\posts::where('id',$object->posts_id)->get()->first() ?>
            <a href="{{url($url::geturl($post))}}"><label for="post">Post :</label></a> {{$post->name}} <b>-></b>  {{$object->permision==0?"Vieuw Permission":"Edit Permission"}}
    </li>

@elseif(!is_null($object->comments_id))
    <li class="comment">
        @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
            <input type="submit" value = "Delete" name = 'delete' onclick="return $(this).val('{{$object->id*2}}')">
        @endif
        <?php $comment = App\comments::where('id',$object->comments_id)->get()->first() ?>
            <a href="{{url($url::geturl($comment))}}"><label for="comment">Comment :</label></a> {!!is_null($object->name)?'name not set id instead : <b>'.$comment->id.'</b>':$comment->name!!} <b>-></b>  {{$object->permision==0?"Vieuw Permission":"Edit Permission"}}
@endif