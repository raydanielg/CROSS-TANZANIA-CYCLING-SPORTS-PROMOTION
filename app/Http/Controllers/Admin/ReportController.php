<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales() 
    { 
        $sales_data = \App\Models\Payment::where('status', 'completed')
            ->selectRaw('SUM(amount) as total, DATE(paid_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();
            
        $total_sales = \App\Models\Payment::where('status', 'completed')->sum('amount');
        $today_sales = \App\Models\Payment::where('status', 'completed')
            ->whereDate('paid_at', today())
            ->sum('amount');
            
        return view('admin.reports.sales', compact('sales_data', 'total_sales', 'today_sales')); 
    }

    public function registrations() 
    { 
        $registration_stats = \App\Models\Registration::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
            
        $recent_registrations = \App\Models\Registration::with(['event', 'participant.user'])
            ->latest()
            ->take(10)
            ->get();
            
        return view('admin.reports.registrations', compact('registration_stats', 'recent_registrations')); 
    }

    public function payments() 
    { 
        $payment_methods = \App\Models\Payment::selectRaw('method, count(*) as count, SUM(amount) as total')
            ->groupBy('method')
            ->get();
            
        $recent_payments = \App\Models\Payment::with('registration.participant.user')
            ->latest()
            ->take(10)
            ->get();
            
        return view('admin.reports.payments', compact('payment_methods', 'recent_payments')); 
    }

    public function participants() 
    { 
        $gender_stats = \App\Models\Participant::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->get();
            
        $status_stats = \App\Models\Participant::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
            
        return view('admin.reports.participants', compact('gender_stats', 'status_stats')); 
    }

    public function events() 
    { 
        $event_stats = \App\Models\Event::withCount('registrations')
            ->get();
            
        return view('admin.reports.events', compact('event_stats')); 
    }

    public function financial() 
    { 
        $revenue_by_event = \App\Models\Event::with(['registrations.payment' => function($query) {
                $query->where('status', 'completed');
            }])
            ->get()
            ->map(function($event) {
                return [
                    'name' => $event->name,
                    'revenue' => $event->registrations->sum(fn($reg) => $reg->payment ? $reg->payment->amount : 0)
                ];
            });
            
        return view('admin.reports.financial', compact('revenue_by_event')); 
    }
}
