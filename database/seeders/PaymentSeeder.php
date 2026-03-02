<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = \App\Models\Event::first();
        $participants = \App\Models\Participant::all();

        foreach ($participants as $participant) {
            $reg = \App\Models\Registration::create([
                'event_id' => $event->id,
                'participant_id' => $participant->id,
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'bib_number' => 'BIB-' . rand(100, 999),
            ]);

            \App\Models\Payment::create([
                'registration_id' => $reg->id,
                'amount' => $event->registration_fee,
                'method' => 'M-Pesa',
                'reference' => 'TXN' . strtoupper(\Illuminate\Support\Str::random(10)),
                'status' => 'completed',
                'paid_at' => now(),
            ]);
        }
    }
}
