<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed FAQs
        $faqs = [
            [
                'question' => 'How do I register for an event?',
                'answer' => 'You can register by clicking the "Quick Register" button on the dashboard or through the Events page.',
                'category' => 'Registration',
                'order' => 1
            ],
            [
                'question' => 'What payment methods are supported?',
                'answer' => 'We support M-Pesa, Tigo Pesa, Airtel Money, and direct bank transfers.',
                'category' => 'Payment',
                'order' => 2
            ],
            [
                'question' => 'How can I change my profile picture?',
                'answer' => 'Go to "My Profile" from the top menu, click the camera icon on your avatar, and upload a new image.',
                'category' => 'General',
                'order' => 3
            ],
        ];

        foreach ($faqs as $faq) {
            \App\Models\SupportFaq::create($faq);
        }

        // 2. Seed Tickets
        $user = \App\Models\User::first();
        if ($user) {
            $tickets = [
                [
                    'user_id' => $user->id,
                    'subject' => 'Payment not reflecting',
                    'message' => 'I paid via M-Pesa but my status is still pending.',
                    'priority' => 'high',
                    'status' => 'open',
                    'category' => 'Billing'
                ],
                [
                    'user_id' => $user->id,
                    'subject' => 'Unable to upload license',
                    'message' => 'The system gives an error when I try to upload my cycling license.',
                    'priority' => 'medium',
                    'status' => 'in_progress',
                    'category' => 'Technical'
                ],
            ];

            foreach ($tickets as $ticket) {
                \App\Models\Ticket::create($ticket);
            }
        }
    }
}
