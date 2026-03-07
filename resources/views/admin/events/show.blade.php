@extends('adminlte::page')

@section('title', 'View Event | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-bicycle mr-2 text-success"></i>Event Details</h1>
        <div class="btn-group">
            <a href="{{ route('admin.events.index') }}" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-info btn-sm ml-2">
                <i class="fas fa-edit mr-1"></i> Edit Event
            </a>
            <form action="{{ route('admin.events.generate-licenses', $event) }}" method="POST" class="ml-2" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-id-card mr-1"></i> Generate License No
                </button>
            </form>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Event Info Card -->
            <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-body box-profile">
                    <div class="text-center mb-3">
                        <i class="fas fa-bicycle fa-4x text-success"></i>
                    </div>
                    <h3 class="profile-username text-center font-weight-bold">{{ $event->name }}</h3>
                    <p class="text-muted text-center">{{ $event->category }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Date</b> <span class="float-right text-bold text-primary">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Location</b> <span class="float-right">{{ $event->location }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Route</b>
                            <span class="float-right">
                                {{ $event->start_location ? $event->start_location : 'TBA' }} 
                                <span class="text-muted">→</span>
                                {{ $event->end_location ? $event->end_location : 'TBA' }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Distance</b>
                            <span class="float-right badge badge-primary">
                                {{ $event->distance_km ? number_format($event->distance_km, 2) : 'TBA' }} KM
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Fee</b> <span class="float-right text-success text-bold">TZS {{ number_format($event->registration_fee) }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Registrations</b> <span class="float-right badge badge-dark">{{ $event->registrations_count }} / {{ $event->max_participants ?? '∞' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Slots Remaining</b>
                            <span class="float-right badge badge-{{ is_null($remaining_slots) ? 'secondary' : ($remaining_slots > 0 ? 'success' : 'danger') }}">
                                {{ is_null($remaining_slots) ? 'Unlimited' : $remaining_slots }}
                            </span>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <b>Status</b> 
                            <span class="float-right badge badge-{{ $event->status == 'upcoming' ? 'success' : ($event->status == 'ongoing' ? 'primary' : 'secondary') }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </li>
                    </ul>

                    @if(!is_null($event->max_participants))
                        @php
                            $capacity_percent = $event->max_participants > 0 ? min(100, round(($event->registrations_count / $event->max_participants) * 100)) : 0;
                        @endphp
                        <div class="mt-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">Capacity Used</span>
                                <span class="text-muted small">{{ $capacity_percent }}%</span>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-{{ $capacity_percent >= 90 ? 'danger' : ($capacity_percent >= 70 ? 'warning' : 'success') }}" style="width: {{ $capacity_percent }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description Card -->
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInLeft" style="animation-delay: 0.2s">
                <div class="card-header">
                    <h3 class="card-title">About this Event</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $event->description ?? 'No description provided.' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Registration List Card -->
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-users mr-2"></i>Registered Participants</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.events.participants.pdf', $event) }}" target="_blank" class="btn btn-sm btn-outline-primary mr-2" title="Export PDF">
                            <i class="fas fa-file-pdf mr-1"></i> Export PDF
                        </a>
                        <span class="badge badge-dark mr-2">
                            Total: {{ $event->registrations_count }}
                        </span>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rider</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>License No</th>
                                    <th>Bib #</th>
                                    <th>Status</th>
                                    <th>Reg. Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($event->registrations as $registration)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="font-weight-bold">
                                                {{ $registration->participant->user->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $registration->event_license_no ?? '' }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $gender = $registration->participant->gender ?? null;
                                                $genderClass = $gender === 'Female' ? 'danger' : ($gender === 'Male' ? 'primary' : 'secondary');
                                            @endphp
                                            <span class="badge badge-{{ $genderClass }}">
                                                {{ $gender ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $registration->participant->phone ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $registration->participant->user->email ?? '' }}" class="text-muted">
                                                {{ $registration->participant->user->email ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">
                                                {{ $registration->event_license_no ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">{{ $registration->bib_number ?? 'TBA' }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $regStatusClass = [
                                                    'paid' => 'success',
                                                    'confirmed' => 'success',
                                                    'pending' => 'warning',
                                                    'cancelled' => 'danger'
                                                ][$registration->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $regStatusClass }}">{{ ucfirst($registration->status) }}</span>
                                        </td>
                                        <td>
                                            {{ $registration->created_at ? $registration->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted small">
                                            No participants registered yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
