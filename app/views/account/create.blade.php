@extends('layout.main')

@section('title')
    Create Account
@stop

@section('content')
    <form action="{{ URL::route('account-create-post') }}" method="POST" >

        <div>
            Email: <input type="text" name="email" value="{{ (Input::old('email')) ? e(Input::old('email'))  : '' }}">
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>
       
        <div>
            Username: <input type="text" name="username" value="{{ (Input::old('username')) ? e(Input::old('username'))  : '' }}">
            @if($errors->has('username'))
                {{ $errors->first('username') }}
            @endif
        </div>
       
        <div>
            Password: <input type="password" name="password" value="{{ (Input::old('password')) ? e(Input::old('password'))  : '' }}">
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>
       
        <div>
            Re-Enter Password: <input type="password" name="password_reenter" value="{{ (Input::old('password_reenter')) ? e(Input::old('password_reenter'))  : '' }}">
            @if($errors->has('password_reenter'))
                {{ $errors->first('password_reenter') }}
            @endif
        </div>

        <input type="submit" value="Create Account" />
        {{ Form::token() }}
    </form>
@stop