@extends('layouts/app')

@section('content')
    @include('js/tinymc')
    <form method="POST" id = 'newcomment' role = "form" action="{{route('editComment',[$maintopic,$subtopic,$post->first()->id,$comment->id])}}">
        {{ csrf_field() }}
        @if(auth_level(6))
            @include('forum/layout/author')
            @endif
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-4 control-label">Title</label>

            <div class="col-md-6">
                <input id="title" type="text" class="form-control" placeholder = "Optional !" name="title" value="{{ $comment->name }}" autofocus>

                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="content" class="col-md-4 control-label">Content</label>

            <div class="col-md-6">
                <textarea id="commentContent" class="form-control mce" name="commentContent" autofocus>{!! $comment->content !!}</textarea>

                @if ($errors->has('commentContent'))
                    <span class="help-block">
                        <strong>{{ $errors->first('commentContent') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        @if(auth_level(6))
            @include('forum/layout/upper')
        @endif

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            <label for="priority" class="col-md-4 control-label">Priority</label>

            <div class="col-md-6">
                <input id="priority" type="number" class="form-control" name="priority" value="{{ $comment->priority }}" autofocus>

                @if ($errors->has('priority'))
                    <span class="help-block">
                        <strong>{{ $errors->first('priority') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="rating"> Reset comment rating
                    </label>
                </div>
            </div>
        </div>

        @include('forum/layout/cansee')
        @if(auth_level(6))
            @include('forum/layout/canedit')
            @endif
        @if(user_edit_permission($comment))
            @include ("forum/layout/specialperm")
        @endif
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>


@endsection