@extends('layouts.default')
@section('title', 'user info edit')

@section('content')
  <div class="offset-md-2 col-md-8">
    <div class="card">
      <div class="card-header">
        <h5>user info edit</h5>
      </div>
      <div class="card-body">
        @include('shared._errors')
        <div class="gravatar_edit">
            <a href="http://gravatar.com/emails" target="_blank">
              <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" class="gravatar"/>
            </a>
          </div>
        <form method="post" action=" {{ route('users.update', $user->id) }}">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

          <div class="form-group">
            <label for="email">email: {{ $user->email }}</label>
          </div>

          <div class="form-group">
            <label for="name">name: </label>
            <input id="name" type="text" name="name" class="form-control" value="{{ $user->name }}">
          </div>

          <div class="form-group">
            <label for="password">password: </label>
            <input id="password" type="password" name="password" class="form-control" value="{{ old('password') }}" >
          </div>

          <div class="form-group">
            <label for="password_confirmation">password_confirmation: </label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" >
          </div>

          <button type="submit" class="btn btn-primary">update</button>
        </form>
      </div>
    </div>
  </div>
@stop
