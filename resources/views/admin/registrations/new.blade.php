@extends('adminlte::page')

@section('title', 'New Registrations | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-plus-circle mr-2 text-success"></i>New Registrations</h1>
        <button type="button" class="btn btn-success shadow-sm" data-toggle="modal" data-target="#quickAddRegistration">
            <i class="fas fa-user-plus mr-1"></i> Quick Register
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Recent Signups</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#quickAddRegistration">
                    <i class="fas fa-user-plus mr-1"></i> Quick Add
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rider Details</th>
                            <th>Event</th>
                            <th>Bib #</th>
                            <th>Status</th>
                            <th>Registered At</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr id="reg-row-{{ $reg->id }}">
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
                                <td>
                                    <span class="text-sm font-weight-bold text-success">{{ $reg->event->name }}</span>
                                </td>
                                <td><span class="badge badge-dark p-2">{{ $reg->bib_number }}</span></td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'warning',
                                            'confirmed' => 'success',
                                            'cancelled' => 'danger'
                                        ][$reg->status] ?? 'info';
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }} px-2 py-1">{{ ucfirst($reg->status) }}</span>
                                </td>
                                <td>{{ $reg->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        @if($reg->status === 'pending')
                                            <button class="btn btn-xs btn-success js-confirm-payment" data-id="{{ $reg->id }}" data-name="{{ $reg->participant->user->name }}">
                                                <i class="fas fa-check"></i> Confirm
                                            </button>
                                        @endif
                                        <button class="btn btn-xs btn-danger js-update-status" data-id="{{ $reg->id }}" data-status="cancelled" data-name="{{ $reg->participant->user->name }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No registrations found.</td>
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

    <!-- Quick Register Modal -->
    @include('admin.registrations.modals.quick-add')

    <!-- Confirm Payment Modal -->
    <div class="modal fade" id="confirmPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-check-circle mr-2"></i>Confirm Registration</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-3">Confirm payment for <strong id="confirm-rider-name"></strong>?</p>
                    <div class="form-group text-left">
                        <label>Select Payment Provider</label>
                        <select id="confirm_payment_method" class="form-control">
                            <option value="M-Pesa">Vodacom M-Pesa</option>
                            <option value="Tigo Pesa">Tigo Pesa</option>
                            <option value="Airtel Money">Airtel Money</option>
                            <option value="Bank">Bank Transfer</option>
                            <option value="Manual">Manual Cash</option>
                        </select>
                    </div>
                    <div class="alert alert-info py-2 text-sm text-left">
                        <i class="fas fa-info-circle mr-1"></i> A push notification receipt will be sent to the rider.
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success px-4 shadow-sm" id="processConfirmBtn">
                        <i class="fas fa-check mr-1"></i> Confirm & Activate
                    </button>
                </div>
            </div>
        </div>
    </div>
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
            $('#skip_payment').on('change', function() {
                if($(this).is(':checked')) {
                    $('#payment_fields').fadeOut();
                } else {
                    $('#payment_fields').fadeIn();
                }
            });

            $('#quickRegForm').on('submit', function(e) {
                e.preventDefault();
                var $btn = $('#submitRegBtn');
                var $form = $(this);
                
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Initializing...');

                setTimeout(function() {
                    $btn.html('<i class="fas fa-sync fa-spin mr-1"></i> Sending PUSH request...');
                    
                    $.ajax({
                        url: '{{ route("admin.registrations.store") }}',
                        type: 'POST',
                        data: $form.serialize(),
                        success: function(response) {
                            if(response.success) {
                                $('#quickAddRegistration').modal('hide');
                                
                                var msg = response.message;
                                if(response.license_no) {
                                    msg += '<br><strong>Auto-generated License:</strong> ' + response.license_no;
                                }

                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Registration Success',
                                    autohide: true,
                                    delay: 5000,
                                    body: msg + '<br><small>Push notification sent to device.</small>'
                                });
                                setTimeout(function() { location.reload(); }, 2500);
                            }
                        },
                        error: function(xhr) {
                            $btn.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i> Process Registration');
                            var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong.';
                            alert('Error: ' + errorMsg);
                        }
                    });
                }, 1200); // Small delay to show the "Initializing" state
            });

            $('.js-confirm-payment').on('click', function() {
                selectedRegId = $(this).data('id');
                $('#confirm-rider-name').text($(this).data('name'));
                $('#confirmPaymentModal').modal('show');
            });

            $('#processConfirmBtn').on('click', function() {
                var selectedRegId = $('.js-confirm-payment').data('id');
                if(!selectedRegId) return;
                var $btn = $(this);
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

                $.ajax({
                    url: '/admin/registrations/' + selectedRegId + '/confirm',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_method: $('#confirm_payment_method').val()
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#confirmPaymentModal').modal('hide');
                            $('#reg-row-' + selectedRegId).addClass('animate__animated animate__fadeOutLeft');
                            setTimeout(function() { $('#reg-row-' + selectedRegId).remove(); }, 800);
                            $(document).Toasts('create', { class: 'bg-success', title: 'Success', autohide: true, delay: 3000, body: response.message });
                        }
                    },
                    error: function() {
                        alert('Something went wrong.');
                        $btn.prop('disabled', false).text('Confirm & Activate');
                    }
                });
            });

            $('.js-update-status').on('click', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var name = $(this).data('name');
                if(confirm('Cancel registration for ' + name + '?')) {
                    $.post('/admin/registrations/' + id + '/status', { _token: '{{ csrf_token() }}', status: status }, function(res) {
                        if(res.success) {
                            $('#reg-row-' + id).addClass('animate__animated animate__fadeOutRight');
                            setTimeout(function() { $('#reg-row-' + id).remove(); }, 800);
                        }
                    });
                }
            });
        });
    </script>
@stop
