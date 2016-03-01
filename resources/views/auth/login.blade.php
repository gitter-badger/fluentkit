@extends('auth.layout')

@section('content')
    <login-form url="{{ route('login.post') }}"></login-form>
@endsection