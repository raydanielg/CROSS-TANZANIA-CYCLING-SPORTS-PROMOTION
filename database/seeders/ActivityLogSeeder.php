<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@crosstanzania.com')->first();
        
        $actions = [
            ['action' => 'login', 'description' => 'Admin logged into the system'],
            ['action' => 'update_settings', 'description' => 'Updated system general settings'],
            ['action' => 'create_event', 'description' => 'Created a new event: Dar Grand Tour'],
            ['action' => 'confirm_payment', 'description' => 'Verified M-Pesa payment for GX-302'],
            ['action' => 'export_participants', 'description' => 'Exported active participants list to CSV'],
        ];

        foreach ($actions as $act) {
            \App\Models\ActivityLog::create([
                'user_id' => $admin ? $admin->id : null,
                'action' => $act['action'],
                'description' => $act['description'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            ]);
        }
    }
}
