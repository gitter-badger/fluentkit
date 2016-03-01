@extends('admin.layout')


@section('content')
    <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="app-welcome mdl-cell mdl-cell--12-col mdl-cell--12-col-desktop">
            <h3>Welcome {{ $user->getDisplayName() }}</h3>
        </div>
    </div>
@endsection