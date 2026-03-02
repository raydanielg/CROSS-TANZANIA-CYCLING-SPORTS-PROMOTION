@extends('adminlte::page')

@section('title', 'Notification History | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-history mr-2 text-info"></i>Notification History</h1>
@stop

@section('content')
    <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Sent Messages & Alerts</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Recipient Scope</th>
                            <th>Subject/Alert</th>
                            <th>Status</th>
                            <th>Sent At</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notif)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @php
                                        $typeIcon = [
                                            'email' => 'envelope text-primary',
                                            'sms' => 'sms text-success',
                                            'broadcast' => 'bullhorn text-warning'
                                        ][$notif->type] ?? 'bell';
                                    @endphp
                                    <i class="fas fa-{{ $typeIcon }} mr-1"></i> {{ strtoupper($notif->type) }}
                                </td>
                                <td>
                                    @if($notif->recipient_type === 'event_participants')
                                        <span class="badge badge-info">{{ $notif->event->name ?? 'Event' }} Participants</span>
                                    @elseif($notif->recipient_type === 'individual')
                                        <span class="badge badge-primary">{{ $notif->user->name ?? 'Individual' }}</span>
                                    @else
                                        <span class="badge badge-dark">All Registered Riders</span>
                                    @endif
                                </td>
                                <td><span class="text-sm font-weight-bold">{{ $notif->subject }}</span></td>
                                <td>
                                    <span class="badge badge-success px-2"><i class="fas fa-check-circle mr-1"></i> Sent</span>
                                </td>
                                <td>{{ $notif->sent_at ? $notif->sent_at->format('M d, Y H:i') : $notif->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-default js-view-message" data-message="{{ $notif->message }}" data-subject="{{ $notif->subject }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No notification history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($notifications->hasPages())
            <div class="card-footer">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <!-- View Message Modal -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-envelope-open-text mr-2"></i>Message Content</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h6 class="font-weight-bold" id="msg-subject"></h6>
                    <hr>
                    <div id="msg-content" style="white-space: pre-line;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
            $('.js-view-message').on('click', function() {
                $('#msg-subject').text($(this).data('subject'));
                $('#msg-content').html($(this).data('message'));
                $('#viewMessageModal').modal('show');
            });
        });
    </script>
@stop
