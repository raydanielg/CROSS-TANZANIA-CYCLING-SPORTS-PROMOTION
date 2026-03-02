@extends('adminlte::page')

@section('title', 'Sponsor Payments')

@section('content_header')
    <h1>Sponsor Payment Records</h1>
@stop

@section('content')
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title text-success font-weight-bold">Commitments & Transactions</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Sponsor</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No sponsor payment records found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
