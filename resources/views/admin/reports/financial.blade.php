@extends('adminlte::page')

@section('title', 'Financial Summary')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Financial Summary</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-invoice-dollar mr-1"></i> Generate Statement</button>
            <button type="button" class="btn btn-success btn-sm ml-2"><i class="fas fa-download mr-1"></i> Export Report</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Revenue by Event Chart -->
        <div class="col-md-8">
            <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Revenue Distribution by Event</h3>
                </div>
                <div class="card-body">
                    <canvas id="revenueByEventChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Financial Overview Cards -->
        <div class="col-md-4">
            <div class="info-box bg-gradient-info shadow animate__animated animate__fadeInRight">
                <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-uppercase">Total Gross Revenue</span>
                    <span class="info-box-number">TZS {{ number_format($revenue_by_event->sum('revenue')) }}</span>
                </div>
            </div>

            <div class="card shadow-sm animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-list-ul mr-2"></i>Revenue Breakdown</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($revenue_by_event as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $event['name'] }}</span>
                                <span class="text-bold">TZS {{ number_format($event['revenue']) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
