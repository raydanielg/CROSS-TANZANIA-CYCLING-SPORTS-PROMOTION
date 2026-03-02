@extends('adminlte::page')

@section('title', 'Pending Registrations | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-hourglass-half mr-2 text-warning"></i>Pending Registrations</h1>
        <button type="button" class="btn btn-success shadow-sm" data-toggle="modal" data-target="#quickAddRegistration">
            <i class="fas fa-plus-circle mr-1"></i> Quick Register
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-warning shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold text-dark">Awaiting Payment/Confirmation</h3>
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
                            <th>Reg. Date</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr id="reg-row-{{ $reg->id }}">
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
                                <td>{{ $reg->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-success js-confirm-payment" data-id="{{ $reg->id }}" data-name="{{ $reg->participant->user->name }}">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                        <button class="btn btn-xs btn-danger js-update-status" data-id="{{ $reg->id }}" data-status="cancelled" data-name="{{ $reg->participant->user->name }}">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No pending registrations found.</td>
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

    <!-- Quick Register Modal (Shared with New) -->
    @include('admin.registrations.modals.quick-add')

    <!-- Confirm Payment Modal -->
    <div class="modal fade" id="confirmPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-check-circle mr-2"></i>Confirm Registration</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p>Confirm payment for <strong id="confirm-rider-name"></strong>?</p>
                    <div class="form-group text-left">
                        <label>Payment Provider</label>
                        <select id="confirm_payment_method" class="form-control">
                            <option value="M-Pesa">Vodacom M-Pesa</option>
                            <option value="Tigo Pesa">Tigo Pesa</option>
                            <option value="Airtel Money">Airtel Money</option>
                            <option value="Bank">Bank Transfer</option>
                            <option value="Manual">Manual Receipt</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success px-4 shadow-sm" id="processConfirmBtn">
                        Confirm & Activate
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop

@section('js')
    <script>
        $(function () {
            var selectedRegId = null;

            $('.js-confirm-payment').on('click', function() {
                selectedRegId = $(this).data('id');
                $('#confirm-rider-name').text($(this).data('name'));
                $('#confirmPaymentModal').modal('show');
            });

            $('#processConfirmBtn').on('click', function() {
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
