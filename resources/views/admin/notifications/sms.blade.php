@extends('adminlte::page')

@section('title', 'Send SMS | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-sms mr-2 text-success"></i>SMS Broadcast</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Compose SMS</h3>
                </div>
                <form action="{{ route('admin.notifications.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="sms">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Recipients</label>
                            <select name="recipient_type" class="form-control" id="recipient_type" required>
                                <option value="all">All Registered Riders</option>
                                <option value="event_participants">Participants of a Specific Event</option>
                                <option value="individual">Individual Rider</option>
                            </select>
                        </div>

                        <div class="form-group d-none" id="event_select_group">
                            <label>Select Event</label>
                            <select name="event_id" class="form-control select2" style="width: 100%;">
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Message Content</label>
                            <textarea name="message" id="sms_message" class="form-control @error('message') is-invalid @enderror" rows="5" maxlength="160" placeholder="Enter your SMS message here..." required></textarea>
                            <div class="text-right">
                                <small class="text-muted"><span id="char_count">0</span> / 160 characters</small>
                            </div>
                            @error('message') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-paper-plane mr-1"></i> Send SMS Broadcast
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> SMS Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">Direct SMS to rider phones.</p>
                    <ul class="text-sm pl-3">
                        <li><strong>Standard SMS:</strong> 160 characters per message.</li>
                        <li><strong>Bulk:</strong> Avoid sending too many messages at once to prevent spam filters.</li>
                        <li><strong>Sender ID:</strong> Messages will appear from <strong>CT-CSP</strong>.</li>
                    </ul>
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
            $('#sms_message').on('input', function() {
                var len = $(this).val().length;
                $('#char_count').text(len);
                if(len > 160) {
                    $('#char_count').addClass('text-danger');
                } else {
                    $('#char_count').removeClass('text-danger');
                }
            });

            $('#recipient_type').on('change', function() {
                if($(this).val() === 'event_participants') {
                    $('#event_select_group').removeClass('d-none').hide().fadeIn();
                } else {
                    $('#event_select_group').fadeOut(function() { $(this).addClass('d-none'); });
                }
            });
        });
    </script>
@stop
