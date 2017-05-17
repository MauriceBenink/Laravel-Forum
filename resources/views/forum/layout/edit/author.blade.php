<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
    <label for="author">Author </label>
    <select name="author" id="author">
        <?php $author = $object->author ?>
        <option value="{{$author->id}}">{{$author->display_name}}</option>
        @foreach(\App\User::all()->where('level','>=',2) as $user)
            @if($user->id != $author->id)
            <option value="{{$user->id}}">{{$user->display_name}}</option>
            @endif
            @endforeach
    </select>

    @include('error/inputError',['type' => 'author'])
</div>