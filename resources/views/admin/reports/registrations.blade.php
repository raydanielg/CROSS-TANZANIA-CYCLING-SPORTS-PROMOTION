@extends('adminlte::page')

@section('title', 'Registration Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Registration Report</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf mr-1"></i> PDF</button>
            <button type="button" class="btn btn-success btn-sm ml-2"><i class="fas fa-file-excel mr-1"></i> CSV</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-success shadow-lg animate__animated animate__zoomIn">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Status Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="regStatusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-info shadow-lg animate__animated animate__zoomIn">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-list mr-2"></i>Status Summary</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav flex-column">
                        @foreach($registration_stats as $stat)
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    {{ ucfirst($stat->status) }}
                                    <span class="float-right badge bg-{{ $stat->status == 'confirmed' ? 'success' : ($stat->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $stat->count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-history mr-2"></i>Recent Registrations</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Rider</th>
                            <th>Event</th>
                            <th>Bib Number</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_registrations as $reg)
                            <tr>
                                <td>{{ $reg->participant->user->name ?? 'N/A' }}</td>
                                <td>{{ $reg->event->name ?? 'N/A' }}</td>
                                <td><span class="badge badge-dark">{{ $reg->bib_number ?? 'PENDING' }}</span></td>
                                <td>
                                    <span class="badge badge-{{ $reg->status == 'confirmed' ? 'success' : ($reg->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($reg->status) }}
                                    </span>
                                </td>
                                <td>{{ $reg->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No registrations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
