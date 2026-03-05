<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Juma Hamisi',
                'role' => 'Professional Cyclist',
                'content' => 'Cross Tanzania has transformed the cycling scene in our country. The events are world-class and very well organized.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Anna Mollel',
                'role' => 'Amateur Rider',
                'content' => 'I started as a beginner, and the community here has been so supportive. I\'ve now completed three major challenges!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'David Peter',
                'role' => 'Mountain Biker',
                'content' => 'The routes they pick are breathtaking. It\'s not just about the race, it\'s about experiencing the beauty of Tanzania.',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $item) {
            Testimonial::create($item);
        }
    }
}
