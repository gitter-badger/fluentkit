@extends('auth.layout')

@section('content')
    <forgot-password-form url="{{ route('forgot_password.post') }}"></forgot-password-form>
@endsection