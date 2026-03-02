@extends('adminlte::page')

@section('title', 'Sponsor Contracts')

@section('content_header')
    <h1>Partnership Contracts</h1>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Legal & Partnership Agreements</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Contract ID</th>
                        <th>Sponsor</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Document</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No active sponsor contracts found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
