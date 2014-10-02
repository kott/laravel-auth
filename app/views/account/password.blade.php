@extends('layout.main')

@section('title')
    Change Password
@stop

@section('content')
     <form action="{{ URL::route('account-change-password-post') }}" method="POST" >
        <div>
            Old Password: <input type="password" name="old_password">
            @if($errors->has('old_password'))
                {{ $errors->first('old_password') }}
            @endif
        </div>
       
        <div>
            New Password: <input type="password" name="password">
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>

        <div>
            Re-enter New Password: <input type="password" name="password_reenter">
            @if($errors->has('password_reenter'))
                {{ $errors->first('password_reenter') }}
            @endif
        </div>

        <input type="submit" value="Change Password" />
        {{ Form::token() }}
    </form>
@stop