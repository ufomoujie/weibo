@extends('layouts.default')
@section('title', 'login')

@section('content')
  <div class="offset-md-2 col-md-8">
    <div class="card">
      <div class="card-header">
        <h5>login</h5>
      </div>
      <div class="card-body">
        @include('shared._errors')
        <form method="post" action=" {{ route('login') }}">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="email">email: </label>
            <input id="email" type="text" name="email" class="form-control" value="{{ old('email') }}" >
          </div>

          <div class="form-group">
            <label for="password">password: </label>
            <input id="password" type="password" name="password" class="form-control" value="{{ old('password') }}" >
          </div>

          <button type="submit" class="btn btn-primary">login</button>
        </form>
        <hr>
        <p>not signed?<a href="{{ route('signup')}}"> sign up now</a></p>
      </div>
    </div>
  </div>
@stop
