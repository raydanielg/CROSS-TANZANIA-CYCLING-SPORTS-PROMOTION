@extends('adminlte::page')

@section('title', 'System Backup')

@section('content_header')
    <h1>System Backup & Maintenance</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-database mr-2"></i>Database Backups</h3>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm"><i class="fas fa-plus mr-1"></i> Create New Backup</button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>backup_2024_03_02_1200.sql</code></td>
                                <td>4.2 MB</td>
                                <td>Mar 02, 2024 12:00</td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-xs btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-file-archive mr-2"></i>Media & File Backups</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Last file backup: <strong>Mar 01, 2024</strong></p>
                    <button class="btn btn-info shadow-sm">Backup Media Library</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Automated Backups</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Frequency</label>
                        <select class="form-control">
                            <option>Every Day</option>
                            <option selected>Every Week</option>
                            <option>Every Month</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Retention Policy</label>
                        <input type="text" class="form-control" value="Keep last 30 backups">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-warning btn-block font-weight-bold text-white">Save Schedule</button>
                </div>
            </div>
        </div>
    </div>
@stop
