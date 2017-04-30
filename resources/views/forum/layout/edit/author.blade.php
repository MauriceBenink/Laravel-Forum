<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
    <label for="author">Author </label>
    <select name="author" id="author">
        <option value="{{$object->author->id}}">{{$object->author->display_name}}</option>
        @foreach(\App\User::all()->where('level','>=',2) as $user)
            @if($user->id != $object->author->id)
            <option value="{{$user->id}}">{{$user->display_name}}</option>
            @endif
            @endforeach
    </select>

    @if ($errors->has('author'))
        <span class="help-block">
        <strong>{{ $errors->first('author') }}</strong>
    </span>
    @endif
</div>