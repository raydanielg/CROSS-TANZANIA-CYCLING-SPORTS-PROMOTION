@extends('adminlte::page')

@section('title', 'System Logs')

@section('content_header')
    <h1>System & Activity Logs</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Log Categories</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user-edit mr-2 text-primary"></i> Admin Actions
                                <span class="badge bg-primary float-right">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-exclamation-triangle mr-2 text-danger"></i> System Errors
                                <span class="badge bg-danger float-right">2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-sign-in-alt mr-2 text-success"></i> Login Activity
                                <span class="badge bg-success float-right">45</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Activity Feed</h3>
                    <div class="card-tools">
                        <button class="btn btn-tool" title="Clear Logs"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mar 02, 17:35:12</td>
                                <td>Admin User</td>
                                <td><span class="badge badge-success">Login</span></td>
                                <td>127.0.0.1</td>
                            </tr>
                            <tr>
                                <td>Mar 02, 17:30:05</td>
                                <td>Admin User</td>
                                <td><span class="badge badge-info">Update Settings</span></td>
                                <td>127.0.0.1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
