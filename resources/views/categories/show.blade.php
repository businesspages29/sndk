@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>Role</h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('roles.index') }}"> Back</a>
            </div>
        </div>
        <div class="card p-3 mt-2">
            <div>usersusers
                <b>Name: </b> {{ $role->name }}
            </div>
        </div>
    </div>
@endsection
