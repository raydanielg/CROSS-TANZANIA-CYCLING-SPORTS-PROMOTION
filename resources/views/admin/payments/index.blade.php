@extends('adminlte::page')

@section('title', 'All Transactions')

@section('content_header')
    <h1>Payment Transactions</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>TZS 4.5M</h3>
                    <p>Total Collected</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>TZS 1.2M</h3>
                    <p>Pending Payments</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">All Payments</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>Participant</th>
                        <th>Event</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><code>{{ $payment->reference }}</code></td>
                            <td>{{ $payment->registration->participant->user->name }}</td>
                            <td>{{ $payment->registration->event->name }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td>
                                @if(str_contains(strtolower($payment->method), 'mpesa'))
                                    <span class="badge bg-danger">M-Pesa</span>
                                @elseif(str_contains(strtolower($payment->method), 'tigo'))
                                    <span class="badge bg-primary">Tigo Pesa</span>
                                @else
                                    <span class="badge bg-info">{{ $payment->method }}</span>
                                @endif
                            </td>
                            <td>
                                @if($payment->status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <button class="btn btn-xs btn-outline-info">Details</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No payment transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
