@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <h1>Administrator Accounts</h1>
@stop

@section('content')
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">System Administrators</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @if(str_contains($user->email, 'admin'))
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge badge-danger">Super Admin</span></td>
                            <td>
                                <button class="btn btn-xs btn-outline-primary">Manage</button>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
