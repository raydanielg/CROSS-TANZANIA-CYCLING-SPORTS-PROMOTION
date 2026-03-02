@extends('adminlte::page')

@section('title', 'Completed Payments')

@section('content_header')
    <h1>Completed Payments</h1>
@stop

@section('content')
    <div class="card card-outline card-success">
        <div class="card-header text-success">
            <h3 class="card-title font-weight-bold">Successfully Processed Transactions</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>Participant</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Paid At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><code>{{ $payment->reference }}</code></td>
                            <td>{{ $payment->registration->participant->user->name }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td><span class="badge badge-success">{{ $payment->method }}</span></td>
                            <td>{{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : $payment->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <button class="btn btn-xs btn-info">View Receipt</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No completed payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
