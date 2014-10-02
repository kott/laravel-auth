@extends('layout.main')

@section('title')
    Login
@stop

@section('content')
    <form action="{{ URL::route('account-login-post') }}" method="POST" >
        <div>
            Email: <input type="text" name="email" value="{{ (Input::old('email')) ? e(Input::old('email'))  : '' }}">
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>
       
        <div>
            Password: <input type="password" name="password" value="{{ (Input::old('password')) ? e(Input::old('password'))  : '' }}">
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember" />
            <label for="remember">Remember me</label>
        </div>

        <input type="submit" value="Login" />
        {{ Form::token() }}
    </form>
@stop