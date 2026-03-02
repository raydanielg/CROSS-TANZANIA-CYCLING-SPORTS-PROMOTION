@extends('adminlte::page')

@section('title', 'Staff')

@section('content_header')
    <h1>Staff Members</h1>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Management Staff</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No staff members assigned yet.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
