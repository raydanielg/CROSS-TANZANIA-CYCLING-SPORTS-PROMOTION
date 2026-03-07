@extends('adminlte::page')

@section('title', 'Refunds')

@section('content_header')
    <h1>Payment Refunds</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card card-outline card-info">
        <div class="card-header text-info">
            <h3 class="card-title font-weight-bold">Returned Transactions</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Original Ref</th>
                        <th>Participant</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date Refunded</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><code>{{ $payment->reference }}</code></td>
                            <td>{{ $payment->registration->participant->user->name }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td><span class="badge badge-info">Refunded</span></td>
                            <td>{{ $payment->updated_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No refund records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
