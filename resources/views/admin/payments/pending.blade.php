@extends('adminlte::page')

@section('title', 'Pending Payments')

@section('content_header')
    <h1>Pending Payments</h1>
@stop

@section('content')
    <div class="card card-outline card-warning">
        <div class="card-header text-warning">
            <h3 class="card-title font-weight-bold">Awaiting Transaction Verification</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>Participant</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Initiated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><code>{{ $payment->reference }}</code></td>
                            <td>{{ $payment->registration->participant->user->name }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td><span class="badge badge-info">{{ $payment->method }}</span></td>
                            <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <button class="btn btn-xs btn-success">Verify</button>
                                <button class="btn btn-xs btn-danger">Reject</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No pending payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
