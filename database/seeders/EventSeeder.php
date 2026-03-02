<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Dar es Salaam Grand Tour',
                'slug' => 'dar-grand-tour-' . time(),
                'event_date' => now()->addDays(5)->format('Y-m-d'),
                'location' => 'Dar es Salaam, Tanzania',
                'start_location' => 'Posta',
                'end_location' => 'Kunduchi',
                'distance_km' => 85.50,
                'category' => 'Road Racing',
                'description' => 'A professional road race through the heart of the city.',
                'status' => 'upcoming',
                'registration_fee' => 25000,
                'max_participants' => 200,
            ],
            [
                'name' => 'Mbeya Highlands Challenge',
                'slug' => 'mbeya-highlands-' . time(),
                'event_date' => now()->addDays(15)->format('Y-m-d'),
                'location' => 'Mbeya, Tanzania',
                'start_location' => 'Uyole',
                'end_location' => 'Mbeya Peak',
                'distance_km' => 62.00,
                'category' => 'Mountain Biking',
                'description' => 'Challenging mountain bike race in the highlands.',
                'status' => 'upcoming',
                'registration_fee' => 15000,
                'max_participants' => 100,
            ],
            [
                'name' => 'Arusha Safari Ride',
                'slug' => 'arusha-safari-' . time(),
                'event_date' => now()->subDays(10)->format('Y-m-d'),
                'location' => 'Arusha, Tanzania',
                'start_location' => 'Clock Tower',
                'end_location' => 'Arusha National Park Gate',
                'distance_km' => 48.25,
                'category' => 'Fun Ride',
                'description' => 'A scenic ride through the park.',
                'status' => 'past',
                'registration_fee' => 10000,
                'max_participants' => 300,
            ],
        ];

        foreach ($events as $event) {
            \App\Models\Event::create($event);
        }
    }
}
