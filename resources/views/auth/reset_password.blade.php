@extends('auth.layout')

@section('content')
    <reset-password-form url="{{ route('reset_password.post') }}" token="{{ $token }}"></reset-password-form>
@endsection