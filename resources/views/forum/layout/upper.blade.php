<div class="form-group{{ $errors->has('upper') ? ' has-error' : '' }}">

    <label for="upper">Change comment location</label>
    <select name="upper" id="upper">
        <option value="{{$comment->upper_level_id}}">{{$comment->up->name}}</option>
        @foreach(\App\posts::all()->where('id','=',$comment->upper_level_id) as $post)
            @if($post->id != $comment->upper_level_id)
                <option value="{{$post->id}}">{{$post->name}}</option>
            @endif
        @endforeach
        @foreach(\App\posts::all()->where('id','<>',$comment->upper_level_id) as $post)
                <option value="{{$post->id}}">{{$post->name}}</option>
        @endforeach
    </select>

    @if ($errors->has('author'))
        <span class="help-block">
        <strong>{{ $errors->first('author') }}</strong>
    </span>
    @endif
</div>