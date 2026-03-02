@extends('adminlte::page')

@section('title', 'Failed Payments')

@section('content_header')
    <h1>Failed Payments</h1>
@stop

@section('content')
    <div class="card card-outline card-danger">
        <div class="card-header text-danger">
            <h3 class="card-title font-weight-bold">Unsuccessful Transactions</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>Participant</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Failed At</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><code>{{ $payment->reference }}</code></td>
                            <td>{{ $payment->registration->participant->user->name }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>{{ $payment->updated_at->format('M d, Y H:i') }}</td>
                            <td><span class="text-danger small">Insufficient Balance / Cancelled</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No failed transactions recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
