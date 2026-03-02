@extends('adminlte::page')

@section('title', 'User Roles')

@section('content_header')
    <h1>Roles & Permissions</h1>
@stop

@section('content')
    <div class="row">
        @php
            $roles = [
                ['name' => 'Super Admin', 'desc' => 'Full system access', 'count' => 1, 'color' => 'danger'],
                ['name' => 'Staff', 'desc' => 'Can manage events and registrations', 'count' => 0, 'color' => 'primary'],
                ['name' => 'Participant', 'desc' => 'Can register for events', 'count' => 0, 'color' => 'success'],
            ];
        @endphp

        @foreach($roles as $role)
            <div class="col-md-4">
                <div class="card card-outline card-{{ $role['color'] }}">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">{{ $role['name'] }}</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $role['desc'] }}</p>
                        <hr>
                        <p class="text-muted">Users assigned: <strong>{{ $role['count'] }}</strong></p>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-sm btn-outline-{{ $role['color'] }}">Edit Permissions</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
