@extends('adminlte::page')

@section('title', 'Payment Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Payment Report</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf mr-1"></i> Export PDF</button>
            <button type="button" class="btn btn-success btn-sm ml-2"><i class="fas fa-file-excel mr-1"></i> Export CSV</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Payment Methods Chart -->
        <div class="col-md-7">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Revenue by Payment Method</h3>
                </div>
                <div class="card-body">
                    <canvas id="paymentMethodChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Method Summary Table -->
        <div class="col-md-5">
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-list-alt mr-2"></i>Method Summary</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-valign-middle table-striped">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Count</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_methods as $method)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $method->method == 'M-Pesa' ? 'danger' : ($method->method == 'Tigo Pesa' ? 'info' : 'primary') }}">
                                            {{ $method->method }}
                                        </span>
                                    </td>
                                    <td>{{ $method->count }}</td>
                                    <td class="text-bold">TZS {{ number_format($method->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments Table -->
    <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title"><i class="fas fa-receipt mr-2"></i>Recent Transactions</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Rider</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_payments as $payment)
                            <tr>
                                <td><code>{{ $payment->reference }}</code></td>
                                <td>{{ $payment->registration->participant->user->name ?? 'N/A' }}</td>
                                <td class="text-bold">TZS {{ number_format($payment->amount) }}</td>
                                <td>{{ $payment->method }}</td>
                                <td>
                                    <span class="badge badge-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') : $payment->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">No payments recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
