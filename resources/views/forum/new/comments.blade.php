@extends('layouts/app')


@section('content')
    <form method="POST" role = "form" action="{{route('newComment',[$maintopic,$subtopic,$post])}}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-4 control-label">Title</label>

            <div class="col-md-6">
                <input id="title" type="text" class="form-control" placeholder = "Optional !" name="title" value="{{ old('title') }}" autofocus>

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
                <input id="commentContent" type="text" class="form-control" name="commentContent" value="{{ old('commentContent') }}" required autofocus>

                @if ($errors->has('commentContent'))
                    <span class="help-block">
                        <strong>{{ $errors->first('commentContent') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        @include('forum/layout/cansee')

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
        
    </form>


@endsection