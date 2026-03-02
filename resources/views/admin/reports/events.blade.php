@extends('adminlte::page')

@section('title', 'Event Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Event Report</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf mr-1"></i> Export PDF</button>
            <button type="button" class="btn btn-success btn-sm ml-2"><i class="fas fa-file-excel mr-1"></i> Export CSV</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Event Participation Chart -->
        <div class="col-md-12">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Registrations by Event</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="eventParticipationChart" style="min-height: 300px; height: 300px; max-height: 400px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Summary Table -->
    <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title"><i class="fas fa-table mr-2"></i>Event Performance Summary</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Registrations</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event_stats as $event)
                            <tr>
                                <td class="text-bold">{{ $event->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{ $event->registrations_count }}</span>
                                        <div class="progress progress-xs w-100">
                                            <div class="progress-bar bg-primary" style="width: {{ min(100, ($event->registrations_count / 100) * 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $event->status == 'upcoming' ? 'success' : ($event->status == 'completed' ? 'secondary' : 'warning') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No events found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
