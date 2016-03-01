@extends('auth.layout')

@section('content')
    <register-form url="{{ route('register.post') }}"></register-form>
@endsection