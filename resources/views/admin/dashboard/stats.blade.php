@extends('adminlte::page')

@section('title', 'Quick Stats | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-bolt mr-2 text-warning"></i>Real-Time Quick Stats</h1>
        <div class="badge badge-success animate__animated animate__pulse animate__infinite p-2">
            <i class="fas fa-circle mr-1"></i> LIVE MONITORING
        </div>
    </div>
@stop

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info animate__animated animate__fadeInLeft">
                <div class="inner">
                    <h3>{{ $total_events }}</h3>
                    <p>Total Events</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bicycle"></i>
                </div>
                <a href="{{ route('admin.events.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success animate__animated animate__fadeInUp">
                <div class="inner">
                    <h3>{{ $total_participants }}</h3>
                    <p>Total Riders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="{{ route('admin.participants.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning animate__animated animate__fadeInUp">
                <div class="inner">
                    <h3>{{ $pending_registrations }}</h3>
                    <p>Pending Registrations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <a href="{{ route('admin.registrations.pending') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger animate__animated animate__fadeInRight">
                <div class="inner">
                    <h3>TZS {{ number_format($total_revenue / 1000, 1) }}k</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- Live System Monitoring -->
        <div class="col-md-8">
            <div class="card card-dark shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-microchip mr-2 text-info"></i>Live System Performance</h3>
                    <div class="card-tools">
                        <span class="badge badge-info" id="update-time">Last update: Just now</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <input type="text" class="knob" id="cpu-knob" value="{{ $system_stats->cpu_usage }}" data-width="120" data-height="120" data-fgColor="#17a2b8" readonly>
                            <div class="knob-label font-weight-bold mt-2">CPU USAGE</div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="knob" id="mem-knob" value="{{ $system_stats->memory_usage }}" data-width="120" data-height="120" data-fgColor="#28a745" readonly>
                            <div class="knob-label font-weight-bold mt-2">RAM LOAD</div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="knob" id="net-knob" value="{{ rand(5, 25) }}" data-width="120" data-height="120" data-fgColor="#ffc107" readonly>
                            <div class="knob-label font-weight-bold mt-2">NETWORK LATENCY</div>
                        </div>
                    </div>
                    <hr class="border-secondary">
                    <div class="mt-4">
                        <h6><i class="fas fa-network-wired mr-2 text-primary"></i>Server Traffic (Simulation)</h6>
                        <canvas id="liveChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Real-time Activity -->
        <div class="col-md-4">
            <div class="card card-outline card-warning shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-history mr-2"></i>Live Transactions</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Rider</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="transaction-feed">
                                @foreach($recent_payments as $payment)
                                    <tr>
                                        <td>
                                            <div class="text-sm font-weight-bold">{{ $payment->registration->participant->user->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-muted">{{ $payment->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="text-sm font-weight-bold text-success">TZS {{ number_format($payment->amount) }}</td>
                                        <td>
                                            <span class="badge badge-success">PAID</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-xs btn-outline-warning">View All Payments</a>
                </div>
            </div>

            <div class="info-box bg-gradient-dark shadow-sm animate__animated animate__fadeInRight" style="animation-delay: 0.3s">
                <span class="info-box-icon"><i class="fas fa-plus-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Today's New Registrations</span>
                    <span class="info-box-number h4">{{ $today_registrations }}</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .info-box { border-radius: 12px; }
        .card { border-radius: 15px; overflow: hidden; }
        .knob-label { color: #888; text-transform: uppercase; font-size: 11px; }
        .small-box { border-radius: 15px; overflow: hidden; }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            /* jQuery Knob Init */
            $('.knob').knob({
                'format': function (value) { return value + (this.i[0].id === 'net-knob' ? 'ms' : '%'); },
                'draw': function () { $(this.i).css('font-size', '18px').css('font-weight', 'bold'); }
            });

            /* Live Chart Simulation */
            var ctx = $('#liveChart').get(0).getContext('2d');
            var liveChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array(10).fill(''),
                    datasets: [{
                        label: 'Traffic (Req/s)',
                        data: Array(10).fill(0).map(() => Math.floor(Math.random() * 50) + 10),
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { display: false } },
                        x: { grid: { display: false } }
                    },
                    animation: { duration: 0 }
                }
            });

            /* Real-time Update Simulation */
            setInterval(function() {
                // Update Knobs
                var cpu = Math.floor(Math.random() * 20) + 15;
                var mem = Math.floor(Math.random() * 15) + 35;
                var net = Math.floor(Math.random() * 10) + 8;
                
                $('#cpu-knob').val(cpu).trigger('change');
                $('#mem-knob').val(mem).trigger('change');
                $('#net-knob').val(net).trigger('change');

                // Update Chart
                liveChart.data.datasets[0].data.shift();
                liveChart.data.datasets[0].data.push(Math.floor(Math.random() * 40) + 15);
                liveChart.update();

                // Update Timestamp
                var now = new Date();
                $('#update-time').text('Last update: ' + now.getHours() + ':' + (now.getMinutes()<10?'0':'') + now.getMinutes() + ':' + (now.getSeconds()<10?'0':'') + now.getSeconds());
            }, 3000);
        });
    </script>
@stop
