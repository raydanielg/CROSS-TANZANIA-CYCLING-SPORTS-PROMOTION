@extends('adminlte::page')

@section('title', 'Past Events | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-history mr-2 text-secondary"></i>Past Events History</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-default">
            <i class="fas fa-list mr-1"></i> All Events
        </a>
    </div>
@stop

@section('content')
    <div class="modal fade" id="eventQuickViewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
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
                            <div class="small text-muted">Registrations</div>
                            <div class="font-weight-bold" id="eventQuickViewParticipants">-</div>
                        </div>
                        <div class="col-md-4">
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

    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title text-muted">Completed Cycling Events</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Route</th>
                        <th>Distance</th>
                        <th>Participants</th>
                        <th>Top Winner</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
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
                            <td>
                                <span class="badge badge-info">
                                    {{ $event->registrations_count ?? ($event->max_participants ?? 'N/A') }}
                                </span>
                            </td>
                            <td><span class="text-success font-weight-bold">Juma Hamisi</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('admin.events.show', $event) }}">
                                            <i class="fas fa-eye mr-2 text-muted"></i> View Details
                                        </a>
                                        <button
                                            type="button"
                                            class="dropdown-item js-event-quickview"
                                            data-toggle="modal"
                                            data-target="#eventQuickViewModal"
                                            data-name="{{ $event->name }}"
                                            data-date="{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}"
                                            data-location="{{ $event->location }}"
                                            data-category="{{ $event->category }}"
                                            data-status="{{ ucfirst($event->status) }}"
                                            data-participants="{{ $event->registrations_count ?? 'N/A' }}"
                                        >
                                            <i class="fas fa-bolt mr-2 text-success"></i> Quick View
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('admin.reports.events') }}">
                                            <i class="fas fa-file-alt mr-2 text-secondary"></i> View Report
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.events.results') }}">
                                            <i class="fas fa-trophy mr-2 text-success"></i> View Results
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No past events recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
            <div class="card-footer">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('.js-event-quickview').on('click', function () {
                var $btn = $(this);
                $('#eventQuickViewTitle').text($btn.data('name'));
                $('#eventQuickViewDate').text($btn.data('date'));
                $('#eventQuickViewLocation').text($btn.data('location'));
                $('#eventQuickViewCategory').text($btn.data('category'));
                $('#eventQuickViewStatus').text($btn.data('status'));
                $('#eventQuickViewParticipants').text($btn.data('participants'));
            });
        });
    </script>
@stop
