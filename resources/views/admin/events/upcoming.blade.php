@extends('adminlte::page')

@section('title', 'Upcoming Events | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="far fa-calendar-alt mr-2 text-success"></i>Upcoming Cycling Events</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle mr-1"></i> Add Event
        </a>
    </div>
@stop

@section('content')
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
                            <div class="small text-muted">Status</div>
                            <div class="font-weight-bold" id="eventQuickViewStatus">-</div>
                        </div>
                    </div>
                    <hr>
                    <div class="small text-muted">Preview</div>
                    <div class="text-muted" id="eventQuickViewPreview">-</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($events as $event)
            <div class="col-md-4">
                <div class="card card-outline card-success shadow-sm h-100">
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bold text-success">{{ $event->name }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">Upcoming</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"><i class="fas fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
                        <p class="text-muted mb-2"><i class="fas fa-map-marker-alt mr-2"></i> {{ $event->location }}</p>
                        <p class="text-muted mb-2"><i class="fas fa-route mr-2"></i> {{ $event->start_location ?? 'TBA' }} <span class="mx-1">→</span> {{ $event->end_location ?? 'TBA' }}</p>
                        <p class="text-muted mb-3"><i class="fas fa-ruler-horizontal mr-2"></i> <span class="badge badge-primary">{{ $event->distance_km ? number_format($event->distance_km, 2) : 'TBA' }} KM</span></p>
                        <p class="text-muted mb-3"><i class="fas fa-tag mr-2"></i> {{ $event->category }}</p>
                        <p class="card-text text-sm">{{ Str::limit($event->description, 120) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <div class="row items-center">
                            <div class="col-6">
                                <span class="text-bold text-lg text-success">TZS {{ number_format($event->registration_fee) }}</span>
                            </div>
                            <div class="col-6 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-success btn-sm">Details</a>
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('admin.events.edit', $event) }}"><i class="fas fa-edit mr-2 text-info"></i>Edit</a>
                                        <button
                                            type="button"
                                            class="dropdown-item js-event-quickview"
                                            data-toggle="modal"
                                            data-target="#eventQuickViewModal"
                                            data-name="{{ $event->name }}"
                                            data-date="{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}"
                                            data-location="{{ $event->location }}"
                                            data-category="{{ $event->category }}"
                                            data-fee="TZS {{ number_format($event->registration_fee) }}"
                                            data-status="Upcoming"
                                            data-preview="{{ Str::limit($event->description, 160) }}"
                                        >
                                            <i class="fas fa-bolt mr-2 text-success"></i>Quick View
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card card-outline card-success py-5">
                    <i class="fas fa-calendar-day fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No upcoming events at the moment.</h4>
                    <p class="text-muted">Stay tuned for future cycling sports promotions!</p>
                </div>
            </div>
        @endforelse
    </div>
    
    @if($events->hasPages())
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    @endif
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
                $('#eventQuickViewFee').text($btn.data('fee'));
                $('#eventQuickViewStatus').text($btn.data('status'));
                $('#eventQuickViewPreview').text($btn.data('preview'));
            });
        });
    </script>
@stop
