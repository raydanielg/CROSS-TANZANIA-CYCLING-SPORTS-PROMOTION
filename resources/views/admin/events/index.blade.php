@extends('adminlte::page')

@section('title', 'All Events | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-bicycle mr-2 text-success"></i>Events Management</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle mr-1"></i> Add New Event
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-outline card-success shadow-lg">
        <div class="card-header">
            <h3 class="card-title">List of All Events</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search events...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Route</th>
                            <th>Distance</th>
                            <th>Category</th>
                            <th>Fee</th>
                            <th>Participants</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $event->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>
                                    <span class="text-muted">
                                        {{ $event->start_location ?? 'TBA' }}
                                        <span class="mx-1">→</span>
                                        {{ $event->end_location ?? 'TBA' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $event->distance_km ? number_format($event->distance_km, 2) : 'TBA' }} KM
                                    </span>
                                </td>
                                <td><span class="badge badge-info">{{ $event->category }}</span></td>
                                <td>TZS {{ number_format($event->registration_fee) }}</td>
                                <td>
                                    <span class="badge badge-dark">
                                        {{ $event->registrations_count }} / {{ $event->max_participants ?? '∞' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'upcoming' => 'success',
                                            'ongoing' => 'primary',
                                            'past' => 'secondary',
                                            'cancelled' => 'danger'
                                        ][$event->status] ?? 'info';
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Event actions">
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-default" data-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button
                                            type="button"
                                            class="btn btn-success js-event-quickview"
                                            data-toggle="modal"
                                            data-target="#eventQuickViewModal"
                                            data-name="{{ $event->name }}"
                                            data-date="{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}"
                                            data-location="{{ $event->location }}"
                                            data-route="{{ ($event->start_location ?? 'TBA') . ' → ' . ($event->end_location ?? 'TBA') }}"
                                            data-distance="{{ $event->distance_km ? number_format($event->distance_km, 2) : 'TBA' }} KM"
                                            data-category="{{ $event->category }}"
                                            data-fee="TZS {{ number_format($event->registration_fee) }}"
                                            data-status="{{ ucfirst($event->status) }}"
                                            data-participants="{{ $event->registrations_count }} / {{ $event->max_participants ?? '∞' }}"
                                            data-toggle="tooltip"
                                            title="Quick View"
                                        >
                                            <i class="fas fa-bolt"></i>
                                        </button>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-info" data-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            type="button"
                                            class="btn btn-danger js-event-delete"
                                            data-toggle="modal"
                                            data-target="#eventDeleteModal"
                                            data-name="{{ $event->name }}"
                                            data-action="{{ route('admin.events.destroy', $event) }}"
                                            data-toggle="tooltip"
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">No events found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($events->hasPages())
            <div class="card-footer clearfix">
                {{ $events->links() }}
            </div>
        @endif
    </div>

    <div class="modal fade" id="eventQuickViewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-bicycle mr-2"></i>
                        <span id="eventQuickViewTitle">Event</span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small text-muted">Date</div>
                            <div class="font-weight-bold" id="eventQuickViewDate">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Location</div>
                            <div class="font-weight-bold" id="eventQuickViewLocation">-</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small text-muted">Category</div>
                            <div class="font-weight-bold" id="eventQuickViewCategory">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">Fee</div>
                            <div class="font-weight-bold text-success" id="eventQuickViewFee">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">Participants</div>
                            <div class="font-weight-bold" id="eventQuickViewParticipants">-</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small text-muted">Route</div>
                            <div class="font-weight-bold" id="eventQuickViewRoute">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Distance</div>
                            <div class="font-weight-bold" id="eventQuickViewDistance">-</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="small text-muted">Status</div>
                            <div class="font-weight-bold" id="eventQuickViewStatus">-</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Delete Event</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete:
                    <div class="font-weight-bold mt-2" id="eventDeleteName">Event</div>
                    <div class="text-muted small mt-2">This action cannot be undone.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <form id="eventDeleteForm" method="POST" action="#" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .table td, .table th { vertical-align: middle; }
        .btn-group-sm > .btn { padding: 0.25rem 0.45rem; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.js-event-quickview').on('click', function () {
                var $btn = $(this);
                $('#eventQuickViewTitle').text($btn.data('name'));
                $('#eventQuickViewDate').text($btn.data('date'));
                $('#eventQuickViewLocation').text($btn.data('location'));
                $('#eventQuickViewCategory').text($btn.data('category'));
                $('#eventQuickViewFee').text($btn.data('fee'));
                $('#eventQuickViewParticipants').text($btn.data('participants'));
                $('#eventQuickViewRoute').text($btn.data('route'));
                $('#eventQuickViewDistance').text($btn.data('distance'));
                $('#eventQuickViewStatus').text($btn.data('status'));
            });

            $('.js-event-delete').on('click', function () {
                var $btn = $(this);
                $('#eventDeleteName').text($btn.data('name'));
                $('#eventDeleteForm').attr('action', $btn.data('action'));
            });
        });
    </script>
@stop
