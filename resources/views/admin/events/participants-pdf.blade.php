<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Registered Participants</title>
    <style>
        @page { margin: 18mm 14mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #111; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .brand { font-weight: 800; font-size: 16px; letter-spacing: 0.3px; }
        .subtitle { color: #555; font-size: 12px; margin-top: 4px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 999px; font-size: 11px; border: 1px solid #ddd; }
        .badge.success { border-color: #28a745; color: #28a745; }
        .badge.danger { border-color: #dc3545; color: #dc3545; }
        .badge.secondary { border-color: #6c757d; color: #6c757d; }
        .actions { margin: 12px 0 16px; }
        .btn { display: inline-block; padding: 8px 12px; border-radius: 6px; border: 1px solid #ddd; background: #f8f9fa; text-decoration: none; color: #111; font-size: 12px; cursor: pointer; }
        .btn.primary { background: #006837; border-color: #006837; color: #fff; }
        .meta { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        .meta td { padding: 4px 0; }
        .meta td:first-child { color: #666; width: 140px; }
        table { width: 100%; border-collapse: collapse; }
        thead th { text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px; border-bottom: 2px solid #111; padding: 10px 6px; }
        tbody td { border-bottom: 1px solid #e5e5e5; padding: 9px 6px; font-size: 12px; vertical-align: top; }
        .muted { color: #666; }
        .right { text-align: right; }
        .cover {
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 14px;
        }
        .cover h1 { margin: 0; font-size: 18px; }
        .cover p { margin: 6px 0 0; font-size: 12px; color: #444; }
        .footer { margin-top: 18px; font-size: 11px; color: #666; display: flex; justify-content: space-between; }
        @media print {
            .actions { display: none; }
            .btn { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">{{ config('app.name') }}</div>
            <div class="subtitle">Registered Participants Export</div>
        </div>
        <div style="text-align:right;">
            <div class="badge secondary">Generated: {{ now()->format('M d, Y H:i') }}</div>
        </div>
    </div>

    <div class="actions">
        <button class="btn primary" onclick="window.print()">Print / Save as PDF</button>
        <a class="btn" href="{{ route('admin.events.show', $event) }}">Back to Event</a>
    </div>

    <div class="cover">
        <h1>{{ $event->name }}</h1>
        <p>
            <strong>Location:</strong> {{ $event->location }}
            <span class="muted">|</span>
            <strong>Route:</strong> {{ $event->start_location ?? 'TBA' }} → {{ $event->end_location ?? 'TBA' }}
            <span class="muted">|</span>
            <strong>Distance:</strong> {{ $event->distance_km ? number_format($event->distance_km, 2) : 'TBA' }} KM
        </p>

        <table class="meta">
            <tr>
                <td>Event Date</td>
                <td><strong>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</strong></td>
            </tr>
            <tr>
                <td>Registrations</td>
                <td><strong>{{ $event->registrations_count }}</strong> {{ $event->max_participants ? ' / ' . $event->max_participants : '' }}</td>
            </tr>
            <tr>
                <td>Slots Remaining</td>
                <td>
                    @if(is_null($remaining_slots))
                        <span class="badge secondary">Unlimited</span>
                    @else
                        <span class="badge {{ $remaining_slots > 0 ? 'success' : 'danger' }}">{{ $remaining_slots }}</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 26px;">#</th>
                <th>Rider</th>
                <th>Email</th>
                <th>Phone</th>
                <th>License No</th>
                <th style="width: 70px;">Gender</th>
                <th style="width: 70px;">Bib</th>
                <th style="width: 90px;">Status</th>
                <th class="right" style="width: 110px;">Reg Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($event->registrations as $registration)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $registration->participant->user->name ?? 'N/A' }}</strong>
                    </td>
                    <td>{{ $registration->participant->user->email ?? 'N/A' }}</td>
                    <td>{{ $registration->participant->phone ?? 'N/A' }}</td>
                    <td>{{ $registration->participant->license_no ?? 'N/A' }}</td>
                    <td>{{ $registration->participant->gender ?? 'N/A' }}</td>
                    <td>{{ $registration->bib_number ?? 'TBA' }}</td>
                    <td>{{ ucfirst($registration->status) }}</td>
                    <td class="right">{{ $registration->created_at ? $registration->created_at->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="muted">No participants registered yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="muted">CT-CSP Admin Export</div>
        <div class="muted">Page <script>document.write((function(){return 1;})())</script></div>
    </div>
</body>
</html>
