<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $riders = [
            ['name' => 'Juma Hamisi', 'email' => 'juma@example.com', 'gender' => 'Male', 'license' => 'GX-302'],
            ['name' => 'Sarah John', 'email' => 'sarah@example.com', 'gender' => 'Female', 'license' => 'GX-405'],
            ['name' => 'David Mwita', 'email' => 'david@example.com', 'gender' => 'Male', 'license' => 'GX-512'],
            ['name' => 'Amina Rashid', 'email' => 'amina@example.com', 'gender' => 'Female', 'license' => 'GX-210'],
        ];

        foreach ($riders as $rider) {
            $user = \App\Models\User::create([
                'name' => $rider['name'],
                'email' => $rider['email'],
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
                'profile_photo_path' => null,
            ]);

            \App\Models\Participant::create([
                'user_id' => $user->id,
                'phone' => '255712345678',
                'gender' => $rider['gender'],
                'license_no' => $rider['license'],
                'status' => 'active',
                'bio' => 'Professional cyclist representing Cross Tanzania.',
            ]);
        }
    }
}
