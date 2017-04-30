@extends('layouts/app')


@section('content')
    @include('js/tinymc')

    <form method="POST" id = 'newpost' role = "form" action="{{route('newPost',[$maintopic,$subtopic])}}">
    {{ csrf_field() }}

        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-4 control-label">Title</label>

            <div class="col-md-6">
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" autofocus>

                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="title" class="col-md-4 control-label">Description</label>

            <div class="col-md-6">
                <input id="description" type="text" class="form-control" placeholder = "Short description of your post" name="description" value="{{ old('description') }}" autofocus>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('contentt') ? ' has-error' : '' }}">
            <label for="contentt" class="col-md-4 control-label">Content</label>

            <div class="col-md-6">
                <textarea id="contentt" class="form-control mce" name="contentt" autofocus>{!! old('contentt') !!}</textarea>

                @if ($errors->has('contentt'))
                    <span class="help-block">
                        <strong>{{ $errors->first('contentt') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        @include('forum/layout/edit/cansee',['newname' => 'Post'])

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>

    </form>
@endsection