@extends('adminlte::page')

@section('title', 'System Broadcast | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-bullhorn mr-2 text-warning"></i>System Broadcast</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-warning shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Create System Alert</h3>
                </div>
                <form action="{{ route('admin.notifications.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="broadcast">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Scope</label>
                            <select name="recipient_type" class="form-control" id="recipient_type" required>
                                <option value="all">Global (All Users Dashboard)</option>
                                <option value="event_participants">Event Specific (Dashboard of participants)</option>
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
                            <label>Alert Title</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="e.g. Urgent Update: Route Change" required>
                            @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Alert Message</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Enter broadcast message details..." required></textarea>
                            @error('message') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning px-4 shadow-sm text-dark font-weight-bold">
                            <i class="fas fa-paper-plane mr-1"></i> Post Broadcast
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-history mr-2"></i>Recent Alerts</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($recent_broadcasts as $broadcast)
                            <li class="item">
                                <div class="product-info ml-1">
                                    <span class="text-sm font-weight-bold">{{ $broadcast->subject }}</span>
                                    <span class="badge badge-warning float-right text-xs">{{ $broadcast->sent_at->diffForHumans() }}</span>
                                    <span class="product-description text-xs">
                                        {{ Str::limit($broadcast->message, 60) }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center py-3 text-muted">No recent alerts.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.notifications.history') }}" class="uppercase text-xs font-weight-bold">View All History</a>
                </div>
            </div>

            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-info-circle mr-2"></i>Broadcast Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">Broadcasts appear as alerts on the rider's dashboard upon login.</p>
                    <ul class="text-sm pl-3">
                        <li><strong>Visibility:</strong> Visible until dismissed or event ends.</li>
                        <li><strong>Scope:</strong> Global reaches everyone; Event specific reaches only registered riders.</li>
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
