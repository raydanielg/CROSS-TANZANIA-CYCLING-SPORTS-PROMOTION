@extends('adminlte::page')

@section('title', 'Blacklist | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-slash mr-2 text-danger"></i>Blacklisted Participants</h1>
        <a href="{{ route('admin.participants.index') }}" class="btn btn-default btn-sm">
            <i class="fas fa-users mr-1"></i> All Participants
        </a>
    </div>
@stop

@section('content')
    <div class="card card-outline card-danger shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Restricted Riders</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search blacklist...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Rider Details</th>
                        <th>Contact</th>
                        <th>Reason for Restriction</th>
                        <th>Blacklisted On</th>
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
                                <div class="text-xs">
                                    <div><i class="fas fa-phone-alt mr-1"></i> {{ $participant->phone ?? 'N/A' }}</div>
                                    <div><i class="fas fa-envelope mr-1"></i> {{ $participant->user->email }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="text-sm text-danger"><i class="fas fa-info-circle mr-1"></i> Violation of conduct</span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $participant->updated_at->format('M d, Y H:i') }}</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-success js-restore-rider" 
                                            data-id="{{ $participant->id }}" 
                                            data-name="{{ $participant->user->name }}"
                                            data-toggle="tooltip" title="Restore Access">
                                        <i class="fas fa-user-check mr-1"></i> Unblock
                                    </button>
                                    <a href="{{ route('admin.participants.profile', $participant->id) }}" class="btn btn-default" data-toggle="tooltip" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                                    <p>No riders are currently blacklisted. Good job!</p>
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

    <!-- Restore Confirmation Modal -->
    <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title"><i class="fas fa-user-check mr-2"></i>Confirm Restore</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to restore access for <strong id="restore-rider-name"></strong>?</p>
                    <p class="text-sm text-muted">This rider will be moved back to the active list and can participate in future events.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success shadow-sm" id="confirm-restore-btn">
                        <i class="fas fa-check mr-1"></i> Yes, Restore Access
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
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            var selectedRiderId = null;

            $('.js-restore-rider').on('click', function() {
                selectedRiderId = $(this).data('id');
                $('#restore-rider-name').text($(this).data('name'));
                $('#restoreModal').modal('show');
            });

            $('#confirm-restore-btn').on('click', function() {
                if(!selectedRiderId) return;
                
                var $btn = $(this);
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Restoring...');

                $.ajax({
                    url: '/admin/participants/' + selectedRiderId + '/restore',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#restoreModal').modal('hide');
                            $('#rider-row-' + selectedRiderId).addClass('animate__animated animate__fadeOutLeft');
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
                        $btn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Yes, Restore Access');
                    }
                });
            });
        });
    </script>
@stop
