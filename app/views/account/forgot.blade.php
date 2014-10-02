@extends('layout.main')

@section('title')
    Forgot Password
@stop

@section('content')
    <form action="{{ URL::route('account-forgot-password-post') }}" method="POST" >
        <div>
            Email <input type="text" name="email">
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>

        <input type="submit" value="Recover Account" />
        {{ Form::token() }}
    </form>
@stop