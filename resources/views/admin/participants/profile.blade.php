@extends('adminlte::page')

@section('title', 'Rider Profile | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-user-tie mr-2 text-success"></i>Rider Professional Profile</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-success card-outline shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="https://ui-avatars.com/api/?name={{ urlencode($participant->user->name) }}&size=128&background=006837&color=fff"
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center font-weight-bold">{{ $participant->user->name }}</h3>
                    <p class="text-muted text-center">Rider ID: CT-{{ str_pad($participant->id, 4, '0', STR_PAD_LEFT) }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Gender</b> <a class="float-right badge badge-{{ $participant->gender == 'Female' ? 'danger' : 'primary' }}">{{ $participant->gender }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>License</b> <a class="float-right text-bold"><code>{{ $participant->license_no ?? 'N/A' }}</code></a>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <b>Status</b> <a class="float-right badge badge-{{ $participant->status == 'active' ? 'success' : 'warning' }}">{{ ucfirst($participant->status) }}</a>
                        </li>
                    </ul>

                    <a href="mailto:{{ $participant->user->email }}" class="btn btn-success btn-block shadow-sm"><b><i class="fas fa-envelope mr-1"></i> Message Rider</b></a>
                </div>
            </div>

            <!-- About Me Box -->
            <div class="card card-success shadow-lg animate__animated animate__fadeInLeft" style="animation-delay: 0.2s">
                <div class="card-header">
                    <h3 class="card-title">Contact & Bio</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                    <p class="text-muted">{{ $participant->phone ?? 'N/A' }}</p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                    <p class="text-muted">Tanzania</p>
                    <hr>
                    <strong><i class="fas fa-file-alt mr-1"></i> Bio</strong>
                    <p class="text-muted text-sm">{{ $participant->bio ?? 'This rider has not provided a bio yet.' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box bg-gradient-info shadow-sm animate__animated animate__zoomIn">
                        <span class="info-box-icon"><i class="fas fa-bicycle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Events</span>
                            <span class="info-box-number">{{ $stats['total_events'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-gradient-success shadow-sm animate__animated animate__zoomIn" style="animation-delay: 0.1s">
                        <span class="info-box-icon"><i class="fas fa-road"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Distance</span>
                            <span class="info-box-number">{{ number_format($stats['total_distance'], 1) }} KM</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-gradient-primary shadow-sm animate__animated animate__zoomIn" style="animation-delay: 0.2s">
                        <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Paid</span>
                            <span class="info-box-number">TZS {{ number_format($stats['total_paid']) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#history" data-toggle="tab"><i class="fas fa-history mr-1"></i> Event History</a></li>
                        <li class="nav-item"><a class="nav-link" href="#payments" data-toggle="tab"><i class="fas fa-receipt mr-1"></i> Payments</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="history">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Date</th>
                                            <th>Bib #</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($participant->registrations as $reg)
                                            <tr>
                                                <td class="font-weight-bold">{{ $reg->event->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reg->event->event_date)->format('M d, Y') }}</td>
                                                <td><span class="badge badge-dark">{{ $reg->bib_number ?? 'TBA' }}</span></td>
                                                <td>
                                                    <span class="badge badge-{{ $reg->status == 'confirmed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($reg->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">No event history found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="payments">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ref #</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($participant->registrations as $reg)
                                            @if($reg->payment)
                                                <tr>
                                                    <td><code>{{ $reg->payment->reference }}</code></td>
                                                    <td class="font-weight-bold text-success">TZS {{ number_format($reg->payment->amount) }}</td>
                                                    <td>{{ $reg->payment->method }}</td>
                                                    <td>{{ $reg->payment->paid_at ? \Carbon\Carbon::parse($reg->payment->paid_at)->format('M d, Y') : 'N/A' }}</td>
                                                    <td><span class="badge badge-success">Completed</span></td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">No payment records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
