@extends('layouts/app')

@section('content')
    @include('js/tinymc')
    <form method="POST" id = 'editMainTopic' role = "form" action="{{route('editMainTopic',[$maintopic->id])}}">
    {{ csrf_field() }}
    @include('forum/layout/edit/title',['object' => $maintopic])
    @include('forum/layout/edit/description',['object' => $maintopic])
    @include('forum/layout/edit/priority',['object' => $maintopic])
    @include('forum/layout/edit/cansee',['object' => $maintopic])
    @include('forum/layout/edit/canedit',['object' => $maintopic])
    @include ("forum/layout/edit/specialperm",['object' => $maintopic])

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </form>
@endsection
