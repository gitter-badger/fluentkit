@extends('admin.layout')

@section('content')
    <admin-roles-page url="{{ route('api.roles') }}"></admin-roles-page>
@endsection