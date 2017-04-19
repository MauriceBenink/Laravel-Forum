
@extends('layouts.app')

@section('content')
 <div class="container">
  <div class="row">
   <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
     <div class="panel-heading">{{\Illuminate\Support\Facades\Auth::user()->account_status() }}</div>
     <div class="panel-body">
      <form class="form-horizontal" role="form" method="POST" action="{{ route('validation') }}">
       {{ csrf_field() }}

       <div class="form-group{{ $errors->has('hash') ? ' has-error' : '' }}">
         @if(isset($hash)&&!empty($hash))
         <div class="col-md-6">
          <input type="hidden" id="hash" class="form-control" name="hash" value = "{{$hash}}">
         @else
         <label for="hash" class="col-md-4 control-label">Code </label>

         <div class="col-md-6">
          <input id="hash" type="text" class="form-control" name="hash" value = "{{old('hash')}}" required autofocus>
         @endif
          @include('error/inputError',['type' => 'hash'])
          </div>
       </div>

       <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
         <button type="submit" class="btn btn-primary">
          Submit Code
         </button>
        </div>
       </div>

      </form>
     </div>
    </div>
   </div>
  </div>
 </div>

@endsection