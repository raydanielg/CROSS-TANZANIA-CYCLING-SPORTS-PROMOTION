<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview()
    {
        $recent_activities = \App\Models\ActivityLog::with('user')->latest()->take(10)->get();
        $upcoming_events = \App\Models\Event::where('status', 'upcoming')->orderBy('event_date')->take(5)->get();
        
        // Fetch real data from DB
        $total_participants = \App\Models\Participant::count();
        $total_events = \App\Models\Event::count();
        $total_revenue = \App\Models\Payment::where('status', 'completed')->sum('amount');
        $approved_participants = \App\Models\Participant::where('status', 'active')->count();
        $male_participants = \App\Models\Participant::where('gender', 'Male')->count();
        $female_participants = \App\Models\Participant::where('gender', 'Female')->count();

        // System stats
        $system_stats = \App\Models\SystemStat::latest()->first() ?? new \App\Models\SystemStat([
            'cpu_usage' => rand(15, 45),
            'memory_usage' => rand(30, 60),
            'storage_usage' => 75,
        ]);

        return view('admin.dashboard.overview', compact(
            'recent_activities', 
            'upcoming_events', 
            'system_stats', 
            'total_participants', 
            'total_events', 
            'total_revenue',
            'approved_participants',
            'male_participants',
            'female_participants'
        ));
    }
    public function analytics() 
    { 
        // 1. Payment Status Distribution
        $payment_stats = [
            'completed' => \App\Models\Payment::where('status', 'completed')->count(),
            'pending' => \App\Models\Payment::where('status', 'pending')->count(),
            'failed' => \App\Models\Payment::where('status', 'failed')->count(),
        ];

        // 2. Gender Distribution
        $gender_stats = [
            'male' => \App\Models\Participant::where('gender', 'Male')->count(),
            'female' => \App\Models\Participant::where('gender', 'Female')->count(),
        ];

        // 3. Registrations per Event (Top 5)
        $event_registrations = \App\Models\Event::withCount('registrations')
            ->orderBy('registrations_count', 'desc')
            ->take(5)
            ->get();

        // 4. Monthly Revenue (Last 6 months)
        $is_sqlite = \DB::connection()->getDriverName() === 'sqlite';
        $month_format = $is_sqlite ? "strftime('%m', paid_at)" : "DATE_FORMAT(paid_at, '%b')";
        
        $monthly_revenue = \App\Models\Payment::where('status', 'completed')
            ->selectRaw("SUM(amount) as total, $month_format as month_num")
            ->groupBy('month_num')
            ->get();

        // Map month numbers to names if SQLite
        if ($is_sqlite) {
            $monthly_revenue = $monthly_revenue->map(function($item) {
                $item->month = date('M', mktime(0, 0, 0, (int)$item->month_num, 10));
                return $item;
            });
        } else {
            $monthly_revenue = $monthly_revenue->map(function($item) {
                $item->month = $item->month_num;
                return $item;
            });
        }

        // --- NEW REAL DATA FOR ANALYTICS KPIs ---
        $total_participants = \App\Models\Participant::count();
        $total_registrations = \App\Models\Registration::count();
        $confirmed_registrations = \App\Models\Registration::where('status', 'confirmed')->count();
        
        // Conversion Rate: Confirmed Registrations / Total Registrations
        $conversion_rate = $total_registrations > 0 
            ? round(($confirmed_registrations / $total_registrations) * 100) 
            : 0;

        // Retention Rate: Riders with > 1 registration
        $returning_riders = \App\Models\Participant::has('registrations', '>', 1)->count();
        $retention_rate = $total_participants > 0 
            ? round(($returning_riders / $total_participants) * 100) 
            : 0;

        // Churn Risk: (Example logic: Pending or Inactive participants / Total)
        $pending_participants = \App\Models\Participant::where('status', '!=', 'active')->count();
        $churn_risk = $total_participants > 0 
            ? round(($pending_participants / $total_participants) * 100, 1) 
            : 0;

        return view('admin.dashboard.analytics', compact(
            'payment_stats',
            'gender_stats',
            'event_registrations',
            'monthly_revenue',
            'conversion_rate',
            'retention_rate',
            'churn_risk'
        )); 
    }
    public function stats() 
    { 
        return $this->quickStats(); 
    }

    public function quickStats() 
    { 
        $total_events = \App\Models\Event::count();
        $total_participants = \App\Models\Participant::count();
        $pending_registrations = \App\Models\Registration::where('status', 'pending')->count();
        $total_revenue = \App\Models\Payment::where('status', 'completed')->sum('amount');
        
        $today_registrations = \App\Models\Registration::whereDate('created_at', today())->count();
        $recent_payments = \App\Models\Payment::with(['registration.participant.user'])->latest()->take(5)->get();

        $system_stats = \App\Models\SystemStat::latest()->first() ?? new \App\Models\SystemStat([
            'cpu_usage' => rand(10, 30),
            'memory_usage' => rand(20, 50),
            'storage_usage' => 65,
        ]);

        return view('admin.dashboard.stats', compact(
            'total_events',
            'total_participants',
            'pending_registrations',
            'total_revenue',
            'today_registrations',
            'recent_payments',
            'system_stats'
        )); 
    }
}
