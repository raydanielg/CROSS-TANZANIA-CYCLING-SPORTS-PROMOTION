@extends('adminlte::page')

@section('title', 'Check-in List | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-id-badge mr-2 text-success"></i>Event Check-in Management</h1>
        <button type="button" class="btn btn-success shadow-sm" data-toggle="modal" data-target="#quickAddRegistration">
            <i class="fas fa-plus-circle mr-1"></i> Quick Add
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold">Confirmed Riders for Check-in</h3>
                    <div class="card-tools d-flex">
                        <div class="input-group input-group-sm" style="width: 300px;">
                            <input type="text" name="bib_search" id="bib_search" class="form-control float-right" placeholder="Scan Bib or Search Name...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="checkin-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rider</th>
                                    <th>Event</th>
                                    <th>Bib #</th>
                                    <th>Payment</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $reg)
                                    <tr id="checkin-row-{{ $reg->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $reg->participant->user->profile_photo_url }}" class="img-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;">
                                                <div>
                                                    <div class="font-weight-bold text-sm">{{ $reg->participant->user->name }}</div>
                                                    <div class="text-xs text-muted">{{ $reg->participant->phone }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-sm font-weight-bold text-success">{{ $reg->event->name }}</span></td>
                                        <td><span class="badge badge-dark p-2">{{ $reg->bib_number }}</span></td>
                                        <td>
                                            @if($reg->payment && $reg->payment->status === 'completed')
                                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Paid</span>
                                            @else
                                                <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-{{ $reg->checked_in ? 'warning' : 'success' }} shadow-sm js-toggle-checkin" 
                                                    data-id="{{ $reg->id }}" 
                                                    data-name="{{ $reg->participant->user->name }}"
                                                    data-status="{{ $reg->checked_in ? 'out' : 'in' }}">
                                                <i class="fas fa-{{ $reg->checked_in ? 'undo' : 'user-check' }} mr-1"></i> 
                                                {{ $reg->checked_in ? 'Undo Check-in' : 'Check-in' }}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No confirmed riders available for check-in.</td>
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
        </div>
    </div>

    <!-- Quick Register Modal -->
    @include('admin.registrations.modals.quick-add')
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .select2-container--default .select2-selection--single { height: 38px; border: 1px solid #ced4da; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            // Check-in Toggle Logic
            $('.js-toggle-checkin').on('click', function() {
                var $btn = $(this);
                var id = $btn.data('id');
                var currentStatus = $btn.data('status');
                
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '/admin/registrations/' + id + '/toggle-checkin',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            if(response.checked_in) {
                                $btn.removeClass('btn-success').addClass('btn-warning').data('status', 'out').html('<i class="fas fa-undo mr-1"></i> Undo Check-in');
                            } else {
                                $btn.removeClass('btn-warning').addClass('btn-success').data('status', 'in').html('<i class="fas fa-user-check mr-1"></i> Check-in');
                            }
                            
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Success',
                                autohide: true,
                                delay: 3000,
                                body: response.message
                            });
                        }
                    },
                    error: function() {
                        alert('Something went wrong.');
                        location.reload();
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@stop
