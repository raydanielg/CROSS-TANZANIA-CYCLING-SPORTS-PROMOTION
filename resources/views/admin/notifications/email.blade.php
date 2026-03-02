@extends('adminlte::page')

@section('title', 'Send Email | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-envelope mr-2 text-primary"></i>Email Broadcast</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Compose Email</h3>
                </div>
                <form action="{{ route('admin.notifications.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="email">
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
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter email subject" required>
                            @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Message Content</label>
                            <textarea name="message" id="summernote" class="form-control @error('message') is-invalid @enderror" rows="10" required></textarea>
                            @error('message') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="fas fa-paper-plane mr-1"></i> Send Email Broadcast
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb"></i> Guidelines</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">Use this tool to send professional emails to your riders.</p>
                    <ul class="text-sm">
                        <li><strong>Personalization:</strong> You can use placeholders like [RiderName] in the message.</li>
                        <li><strong>Attachments:</strong> For now, only text and embedded links are supported.</li>
                        <li><strong>History:</strong> All sent emails are recorded in the history tab.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            $('#summernote').summernote({
                height: 300,
                placeholder: 'Write your email content here...'
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
