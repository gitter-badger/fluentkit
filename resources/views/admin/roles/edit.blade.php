@extends('admin.layout')

@section('content')
    <div id="admin-roles-page">
        <admin-roles-edit id="{{ $id }}"></admin-roles-edit>
    </div>
@endsection