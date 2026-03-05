@extends('adminlte::page')

@section('title', __('adminlte::menu.all_participants') . ' | ' . config('app.name'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-users mr-2 text-success"></i>{{ __('adminlte::menu.all_participants') }}</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.participants.export') }}" class="btn btn-info shadow-sm">
                <i class="fas fa-file-export"></i> {{ __('adminlte::menu.export_list') }}
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-list mr-2"></i>Participant Directory</h3>
            <div class="card-tools d-flex">
                <div class="input-group input-group-sm mr-2" style="width: 200px;">
                    <select class="form-control" name="gender_filter">
                        <option value="">All Genders</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search participants...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0" id="participants-table">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Rider Details</th>
                        <th>Gender</th>
                        <th>Contact Info</th>
                        <th>License No</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr id="rider-row-{{ $participant->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <img src="{{ $participant->user->profile_photo_url }}" class="img-circle elevation-1" style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $participant->user->name }}</div>
                                        <div class="text-xs text-muted">ID: CT-{{ str_pad($participant->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $participant->gender == 'Female' ? 'danger' : 'primary' }}">
                                    <i class="fas fa-{{ $participant->gender == 'Female' ? 'venus' : 'mars' }} mr-1"></i>
                                    {{ $participant->gender }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div><i class="fas fa-phone-alt mr-1 text-muted"></i> {{ $participant->phone ?? 'N/A' }}</div>
                                    <div><i class="fas fa-envelope mr-1 text-muted"></i> <span class="text-xs">{{ $participant->user->email }}</span></div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-dark">
                                    <i class="fas fa-id-card mr-1 text-warning"></i>
                                    {{ $participant->license_no ?? 'NO LICENSE' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'inactive' => 'secondary',
                                        'blacklisted' => 'danger'
                                    ][$participant->status] ?? 'info';
                                @endphp
                                <span class="badge badge-{{ $statusClass }} px-3 py-2 status-label">
                                    {{ ucfirst($participant->status) }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.participants.profile', $participant->id) }}" class="btn btn-success" data-toggle="tooltip" title="View & Edit Profile">
                                        <i class="fas fa-user-edit mr-1"></i> Profile
                                    </a>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                        <button type="button" class="dropdown-item js-view-history" data-id="{{ $participant->id }}">
                                            <i class="fas fa-history mr-2 text-primary"></i> Event History
                                        </button>
                                        <a class="dropdown-item" href="#"><i class="fas fa-wallet mr-2 text-success"></i> Payment Logs</a>
                                        <div class="dropdown-divider"></div>
                                        @if($participant->status !== 'blacklisted')
                                            <button type="button" class="dropdown-item text-danger js-blacklist-rider" data-id="{{ $participant->id }}" data-name="{{ $participant->user->name }}">
                                                <i class="fas fa-ban mr-2"></i> Blacklist Rider
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users-slash fa-3x mb-3"></i>
                                    <p>No participants found in the system.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($participants->hasPages())
            <div class="card-footer">
                {{ $participants->links() }}
            </div>
        @endif
    </div>

    <!-- Event History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title"><i class="fas fa-history mr-2"></i>Event History: <span id="history-rider-name"></span></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Bib #</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="history-content">
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Blacklist Confirmation Modal -->
    <div class="modal fade" id="blacklistModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i>Confirm Blacklist</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to blacklist <strong id="blacklist-rider-name"></strong>?</p>
                    <p class="text-sm text-muted">This rider will be removed from the active list and won't be able to register for new events until restored.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger shadow-sm" id="confirm-blacklist-btn">
                        <i class="fas fa-ban mr-1"></i> Yes, Blacklist Rider
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .table td, .table th { vertical-align: middle; }
        .dropdown-item { cursor: pointer; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            var selectedRiderId = null;

            // View History Logic
            $('.js-view-history').on('click', function() {
                var id = $(this).data('id');
                $('#history-content').html('<tr><td colspan="4" class="text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Loading...</td></tr>');
                $('#historyModal').modal('show');

                $.get('/admin/participants/' + id + '/history-data', function(data) {
                    $('#history-rider-name').text(data.name);
                    var html = '';
                    if(data.history.length > 0) {
                        data.history.forEach(function(item) {
                            html += '<tr>' +
                                '<td>' + item.event + '</td>' +
                                '<td>' + item.date + '</td>' +
                                '<td><span class="badge badge-dark">' + item.bib + '</span></td>' +
                                '<td><span class="badge badge-info">' + item.status + '</span></td>' +
                                '</tr>';
                        });
                    } else {
                        html = '<tr><td colspan="4" class="text-center py-4 text-muted">No history found.</td></tr>';
                    }
                    $('#history-content').html(html);
                });
            });

            // Blacklist Logic
            $('.js-blacklist-rider').on('click', function() {
                selectedRiderId = $(this).data('id');
                $('#blacklist-rider-name').text($(this).data('name'));
                $('#blacklistModal').modal('show');
            });

            $('#confirm-blacklist-btn').on('click', function() {
                if(!selectedRiderId) return;
                
                var $btn = $(this);
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Processing...');

                $.ajax({
                    url: '/admin/participants/' + selectedRiderId + '/blacklist',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#blacklistModal').modal('hide');
                            // Animate and remove row
                            $('#rider-row-' + selectedRiderId).addClass('animate__animated animate__fadeOutRight');
                            setTimeout(function() {
                                $('#rider-row-' + selectedRiderId).remove();
                            }, 800);
                            
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
                        alert('Something went wrong. Please try again.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html('<i class="fas fa-ban mr-1"></i> Yes, Blacklist Rider');
                    }
                });
            });
        });
    </script>
@stop
