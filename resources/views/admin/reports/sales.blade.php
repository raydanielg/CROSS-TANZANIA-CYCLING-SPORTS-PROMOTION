@extends('adminlte::page')

@section('title', 'Sales Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Sales Report</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm" onclick="window.print()"><i class="fas fa-print mr-1"></i> Print</button>
            <button type="button" class="btn btn-success btn-sm ml-2"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-info shadow-sm animate__animated animate__fadeInLeft">
                <div class="inner">
                    <h3>TZS {{ number_format($total_sales) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success shadow-sm animate__animated animate__fadeInUp">
                <div class="inner">
                    <h3>TZS {{ number_format($today_sales) }}</h3>
                    <p>Today's Sales</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-warning shadow-sm animate__animated animate__fadeInRight">
                <div class="inner">
                    <h3>{{ $sales_data->count() }}</h3>
                    <p>Transactions (30 Days)</p>
                </div>
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Daily Sales Trend (Last 30 Days)</h3>
                </div>
                <div class="card-body">
                    <canvas id="salesTrendChart" style="min-height: 300px; height: 300px; max-height: 400px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header">
            <h3 class="card-title">Detailed Sales History</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales_data as $sale)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}</td>
                            <td>TZS {{ number_format($sale->total) }}</td>
                            <td class="text-right">
                                <button class="btn btn-xs btn-primary"><i class="fas fa-eye"></i> View</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No sales data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
