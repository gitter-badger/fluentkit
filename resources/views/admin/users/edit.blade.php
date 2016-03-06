@extends('admin.layout')

@section('content')
    <div id="admin-users-page">
        <admin-users-edit id="{{ $id }}"></admin-users-edit>
    </div>
@endsection