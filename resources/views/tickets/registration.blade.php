<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Event Ticket</title>
    <style>
        :root { --primary: #006837; --text: #111827; --muted: #6b7280; --border: #e5e7eb; }
        * { box-sizing: border-box; }
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; margin: 0; background: #f9fafb; color: var(--text); }
        .wrap { max-width: 900px; margin: 32px auto; padding: 0 16px; }
        .ticket { background: #fff; border: 1px solid var(--border); border-radius: 18px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
        .header { padding: 20px 24px; background: var(--primary); color: #fff; display: flex; justify-content: space-between; gap: 16px; }
        .header h1 { font-size: 18px; margin: 0; letter-spacing: 0.04em; text-transform: uppercase; }
        .header .meta { text-align: right; font-size: 12px; opacity: .9; }
        .content { padding: 24px; display: grid; grid-template-columns: 1.3fr .7fr; gap: 18px; }
        .card { border: 1px solid var(--border); border-radius: 14px; padding: 16px; }
        .label { font-size: 11px; color: var(--muted); font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .value { margin-top: 6px; font-weight: 800; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 12px; }
        .pill { display: inline-block; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; border: 1px solid rgba(255,255,255,.35); }
        .footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; gap: 16px; background: #fff; }
        .muted { color: var(--muted); font-size: 12px; }
        .print { display: inline-block; padding: 10px 14px; border-radius: 12px; background: #111827; color: #fff; text-decoration: none; font-weight: 800; font-size: 12px; }
        @media print { body { background: #fff; } .wrap { margin: 0; max-width: none; } .footer { display: none; } }
    </style>
</head>
<body>
<div class="wrap">
    <div class="ticket">
        <div class="header">
            <div>
                <h1>{{ $event->name ?? 'Event Ticket' }}</h1>
                <div class="muted" style="color: rgba(255,255,255,.85); margin-top: 6px;">
                    {{ $event->location ?? '' }}
                    @if(!empty($event->event_date))
                        &middot; {{ \Carbon\Carbon::parse($event->event_date)->toFormattedDateString() }}
                    @endif
                </div>
            </div>
            <div class="meta">
                <div class="pill">{{ strtoupper((string)($registration->status ?? 'pending')) }}</div>
                <div style="margin-top: 10px;">Ticket ID: {{ $registration->id }}</div>
            </div>
        </div>

        <div class="content">
            <div class="card">
                <div class="label">Participant</div>
                <div class="value">{{ $user->name }}</div>
                <div class="muted">{{ $user->email }}</div>

                <div class="grid">
                    <div>
                        <div class="label">Participant ID</div>
                        <div class="value">{{ $participant->id }}</div>
                    </div>
                    <div>
                        <div class="label">License No</div>
                        <div class="value">{{ $registration->event_license_no ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="label">Bib Number</div>
                        <div class="value">{{ $registration->bib_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="label">Registration Status</div>
                        <div class="value">{{ $registration->status }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="label">Payment</div>
                <div class="value">{{ strtoupper((string)($payment->status ?? 'unpaid')) }}</div>

                <div style="margin-top: 12px;">
                    <div class="label">Amount</div>
                    <div class="value">TZS {{ number_format((float)($payment->amount ?? $event->registration_fee ?? 0)) }}</div>
                </div>

                <div style="margin-top: 12px;">
                    <div class="label">Reference</div>
                    <div class="value" style="font-size: 12px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;">
                        {{ $payment->reference ?? '-' }}
                    </div>
                </div>

                <div style="margin-top: 12px;">
                    <div class="label">Paid At</div>
                    <div class="value">{{ $payment && $payment->paid_at ? $payment->paid_at->toDayDateTimeString() : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="muted">
                Open this ticket and use Print → Save as PDF.
            </div>
            <a class="print" href="#" onclick="window.print(); return false;">Print / Save PDF</a>
        </div>
    </div>
</div>
</body>
</html>
