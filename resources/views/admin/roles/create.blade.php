@extends('admin.layout')

@section('content')
    <admin-roles-create url="{{ route('api.roles.create') }}"></admin-roles-create>
@endsection