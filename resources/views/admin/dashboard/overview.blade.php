@extends('adminlte::page')

@section('title', 'Dashboard Overview')

@section('content_header')
    <h1>{{ config('app.name') }} Overview</h1>
@stop

@section('content')
    <!-- Top Widgets (KPIs) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $total_events }}</h3>
                    <p>Total Events</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bicycle"></i>
                </div>
                <a href="{{ route('admin.events.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($total_revenue) }}</h3>
                    <p>Total Revenue (TZS)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="small-box-footer">Payment Status: Active</div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $total_participants }}</h3>
                    <p>Total Registrations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.participants.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary shadow-sm">
                <div class="inner">
                    <h3>{{ $approved_participants }}</h3>
                    <p>Approved Riders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="small-box-footer">Status: Verified</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Calendar -->
        <div class="col-md-8">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-calendar-alt mr-1"></i>
                        Events Calendar
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div id="calendar" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Server Resources & Gender Stats -->
        <div class="col-md-4">
            <!-- Server Resources with Circle Counters -->
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-server mr-1"></i>
                        Server Resources
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <input type="text" class="knob" value="{{ $system_stats->cpu_usage }}" data-width="90" data-height="90" data-fgColor="#3c8dbc" readonly>
                            <div class="knob-label">CPU LOAD</div>
                        </div>
                        <div class="col-6 mb-3">
                            <input type="text" class="knob" value="{{ $system_stats->memory_usage }}" data-width="90" data-height="90" data-fgColor="#00a65a" readonly>
                            <div class="knob-label">MEMORY</div>
                        </div>
                        <div class="col-6">
                            <input type="text" class="knob" value="{{ $system_stats->storage_usage }}" data-width="90" data-height="90" data-fgColor="#f56954" readonly>
                            <div class="knob-label">STORAGE</div>
                        </div>
                        <div class="col-6 text-center">
                            <div class="mt-4">
                                <i class="fas fa-database fa-3x text-muted"></i>
                                <p class="text-xs mt-2">DB: Connected</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gender Distribution -->
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-venus-mars mr-1"></i>
                        Rider Demographics
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-male text-primary mr-2"></i> Male Riders
                                <span class="float-right badge bg-primary">{{ $male_participants }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-female text-danger mr-2"></i> Female Riders
                                <span class="float-right badge bg-danger">{{ $female_participants }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Recent Activity Log (Moved to sidebar for unyama) -->
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header border-0 text-xs uppercase font-weight-bold">
                    Recent Activity
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($recent_activities as $activity)
                            <li class="item py-1">
                                <div class="product-info ml-1">
                                    <span class="text-xs text-bold">{{ $activity->user->name ?? 'System' }}</span>
                                    <span class="text-xs float-right text-muted">{{ $activity->created_at->diffForHumans() }}</span>
                                    <p class="text-xs mb-0 text-muted">{{ $activity->description }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center text-xs py-2 text-muted">No activities.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            background: white;
            padding: 15px;
        }
        .fc-header-toolbar {
            font-size: 0.85rem;
        }
        .knob-label {
            font-size: 10px;
            font-weight: bold;
            color: #666;
            margin-top: 5px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script>
        $(function () {
            /* jQuery Knob */
            $('.knob').knob({
                'format': function (value) {
                    return value + '%';
                }
            });

            /* FullCalendar */
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                themeSystem: 'bootstrap',
                height: 500,
                events: [
                    @foreach($upcoming_events as $event)
                    {
                        title: '{{ $event->name }}',
                        start: '{{ $event->event_date }}',
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        allDay: true
                    },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            background: white;
            padding: 10px;
        }
        .fc-header-toolbar {
            font-size: 0.8rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                themeSystem: 'bootstrap',
                height: 450,
                events: [
                    @foreach($upcoming_events as $event)
                    {
                        title: '{{ $event->name }}',
                        start: '{{ $event->event_date }}',
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        allDay: true
                    },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@stop
