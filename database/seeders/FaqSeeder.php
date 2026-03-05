<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I register for an event?',
                'answer' => 'You can register by creating an account and visiting the Events page to sign up for any upcoming races.',
                'category' => 'Registration',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'What equipment do I need?',
                'answer' => 'A road or mountain bike in good condition, a helmet, and appropriate cycling gear. We provide water and support along routes.',
                'category' => 'Equipment',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Are beginners welcome?',
                'answer' => 'Absolutely! We have events for all levels, from beginner-friendly rides to competitive races for experienced cyclists.',
                'category' => 'General',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $item) {
            \App\Models\SupportFaq::create($item);
        }
    }
}
