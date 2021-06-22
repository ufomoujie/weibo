@extends('layouts.default')
@section('title', 'signup')

@section('content')
  <div class="offset-md-2 col-md-8">
    <div class="card">
      <div class="card-header">
        <h5>sign up</h5>
      </div>
      <div class="card-body">
        @include('shared._errors')
        <form method="post" action=" {{ route('users.store') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="name">name: </label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}">
          </div>

          <div class="form-group">
            <label for="email">email: </label>
            <input id="email" type="text" name="email" class="form-control" value="{{ old('email') }}" >
          </div>

          <div class="form-group">
            <label for="password">password: </label>
            <input id="password" type="password" name="password" class="form-control" value="{{ old('password') }}" >
          </div>

          <div class="form-group">
            <label for="password_confirmation">password_confirmation: </label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" >
          </div>

          <button type="submit" class="btn btn-primary">sign up</button>
        </form>
      </div>
    </div>
  </div>
@stop
