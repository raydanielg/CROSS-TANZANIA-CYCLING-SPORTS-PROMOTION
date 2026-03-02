@extends('adminlte::page')

@section('title', 'Confirmed Registrations | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-check-double mr-2 text-success"></i>Confirmed Registrations</h1>
@stop

@section('content')
    <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Registered Riders List</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rider</th>
                            <th>Event</th>
                            <th>Bib #</th>
                            <th>Confirmed On</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $reg->participant->user->profile_photo_url }}" class="img-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        <div>
                                            <div class="font-weight-bold text-sm">{{ $reg->participant->user->name }}</div>
                                            <div class="text-xs text-muted">{{ $reg->participant->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-sm">{{ $reg->event->name }}</span></td>
                                <td><span class="badge badge-dark">{{ $reg->bib_number }}</span></td>
                                <td>{{ $reg->confirmed_at ? $reg->confirmed_at->format('M d, Y H:i') : 'N/A' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.participants.profile', $reg->participant_id) }}" class="btn btn-xs btn-outline-primary"><i class="fas fa-user"></i> Profile</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No confirmed registrations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($registrations->hasPages())
            <div class="card-footer">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
