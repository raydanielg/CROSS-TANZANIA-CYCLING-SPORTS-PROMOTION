<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SystemStat::create([
            'cpu_usage' => 24.5,
            'memory_usage' => 48.2,
            'storage_usage' => 75.0,
        ]);
    }
}
