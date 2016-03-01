@extends('admin.layout')

@section('content')
    <admin-settings-page url="{{ route('admin.settings.post') }}" :groups="{{ $groups }}"></admin-settings-page>
@endsection