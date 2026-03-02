@extends('adminlte::page')

@section('title', config('app.name') . ' | Advanced Analytics')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-chart-pie mr-2 text-success"></i>{{ config('app.name') }} Analytics</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm"><i class="fas fa-download mr-1"></i> Export Report</button>
            <button type="button" class="btn btn-primary btn-sm ml-2" onclick="location.reload();"><i class="fas fa-sync-alt mr-1"></i> Refresh</button>
        </div>
    </div>
@stop

@section('content')
    <!-- KPI Row -->
    <div class="row">
        <div class="col-md-3">
            <div class="info-box shadow-sm border-left border-primary animate__animated animate__fadeInLeft">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Conversion Rate</span>
                    <span class="info-box-number">{{ $conversion_rate }}%</span>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: {{ $conversion_rate }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box shadow-sm border-left border-success animate__animated animate__fadeInUp">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Avg. Revenue/Rider</span>
                    <span class="info-box-number">TZS {{ number_format(($monthly_revenue->sum('total') / max(1, $gender_stats['male'] + $gender_stats['female'])), 0) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box shadow-sm border-left border-warning animate__animated animate__fadeInUp">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Retention Rate</span>
                    <span class="info-box-number">{{ $retention_rate }}%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box shadow-sm border-left border-danger animate__animated animate__fadeInRight">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Churn Risk</span>
                    <span class="info-box-number text-danger">{{ $churn_risk }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gender & Payment Pie Charts -->
        <div class="col-md-6">
            <div class="card card-outline card-success shadow-lg animate__animated animate__zoomIn">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-venus-mars mr-2"></i>Rider Gender Distribution</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 text-center">
                            <canvas id="genderChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix mt-4">
                                <li><i class="fas fa-circle text-primary mr-1"></i> Male ({{ $gender_stats['male'] }})</li>
                                <li><i class="fas fa-circle text-danger mr-1"></i> Female ({{ $gender_stats['female'] }})</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-info shadow-lg animate__animated animate__zoomIn">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-money-check-alt mr-2"></i>Payment Status Breakdown</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 text-center">
                            <canvas id="paymentChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix mt-4">
                                <li><i class="fas fa-circle text-success mr-1"></i> Success ({{ $payment_stats['completed'] }})</li>
                                <li><i class="fas fa-circle text-warning mr-1"></i> Pending ({{ $payment_stats['pending'] }})</li>
                                <li><i class="fas fa-circle text-danger mr-1"></i> Failed ({{ $payment_stats['failed'] }})</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Event Popularity (Bar Chart) -->
        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-bicycle mr-2"></i>Event Popularity (Top 5)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="eventChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Growth (Line Chart) -->
        <div class="col-md-4">
            <div class="card bg-gradient-dark shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-area mr-2"></i>Revenue Growth</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .info-box { transition: transform 0.3s; }
        .info-box:hover { transform: translateY(-5px); }
        .chart-legend { list-style: none; padding: 0; }
        .chart-legend li { margin-bottom: 10px; font-weight: 500; font-size: 0.9rem; }
        .border-left { border-left: 5px solid !important; }
        .card { border-radius: 15px; overflow: hidden; }
        .card-header { background: transparent; }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            // Chart.js Global Settings
            Chart.defaults.font.family = "'Source Sans Pro', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
            Chart.defaults.color = '#666';

            // 1. Gender Distribution (Doughnut)
            var genderCtx = $('#genderChart').get(0).getContext('2d');
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [{{ $gender_stats['male'] }}, {{ $gender_stats['female'] }}],
                        backgroundColor: ['#007bff', '#dc3545'],
                        borderWidth: 0,
                        hoverOffset: 20
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    cutout: '70%',
                    animation: { animateScale: true, animateRotate: true },
                    plugins: { legend: { display: false } }
                }
            });

            // 2. Payment Status (Pie)
            var paymentCtx = $('#paymentChart').get(0).getContext('2d');
            new Chart(paymentCtx, {
                type: 'pie',
                data: {
                    labels: ['Completed', 'Pending', 'Failed'],
                    datasets: [{
                        data: [{{ $payment_stats['completed'] }}, {{ $payment_stats['pending'] }}, {{ $payment_stats['failed'] }}],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: { legend: { display: false } },
                    animation: { duration: 2000, easing: 'easeOutBounce' }
                }
            });

            // 3. Event Popularity (Bar)
            var eventCtx = $('#eventChart').get(0).getContext('2d');
            new Chart(eventCtx, {
                type: 'bar',
                data: {
                    labels: [@foreach($event_registrations as $event) '{{ $event->name }}', @endforeach],
                    datasets: [{
                        label: 'Registrations',
                        data: [@foreach($event_registrations as $event) {{ $event->registrations_count }}, @endforeach],
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: '#28a745',
                        borderWidth: 2,
                        borderRadius: 10,
                        hoverBackgroundColor: '#28a745'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: { 
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } },
                    animation: { duration: 1500, easing: 'easeInOutQuart' }
                }
            });

            // 4. Revenue Growth (Line)
            var revenueCtx = $('#revenueChart').get(0).getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: [@foreach($monthly_revenue as $rev) '{{ $rev->month }}', @endforeach],
                    datasets: [{
                        label: 'Revenue (TZS)',
                        data: [@foreach($monthly_revenue as $rev) {{ $rev->total }}, @endforeach],
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#17a2b8',
                        pointBorderWidth: 3,
                        pointHoverRadius: 9
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: { 
                        y: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                        x: { ticks: { color: '#fff' }, grid: { display: false } }
                    },
                    plugins: { legend: { display: false } },
                    animation: { duration: 2500 }
                }
            });
        });
    </script>
@stop
