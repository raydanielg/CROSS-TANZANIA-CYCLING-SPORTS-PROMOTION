<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentPage;

class ContentPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'subtitle' => 'Experience the thrill of cycling through Tanzania',
                'slug' => 'home',
                'content' => 'Welcome to Cross Tanzania Cycling Sports Promotion.',
                'sections' => [
                    'hero' => [
                        'title' => 'Cross Tanzania Cycling Sports Promotion',
                        'subtitle' => 'Experience the thrill of cycling through Tanzania\'s breathtaking landscapes.',
                    ],
                    'mission' => [
                        'title' => 'Our Mission',
                        'content' => 'To promote and develop cycling sports across Tanzania by organizing world-class events.',
                    ],
                    'vision' => [
                        'title' => 'Our Vision',
                        'content' => 'A Tanzania where cycling is a celebrated national sport, accessible to all.',
                    ]
                ],
            ],
            [
                'title' => 'About Us',
                'subtitle' => 'Building Tanzania\'s Cycling Future',
                'slug' => 'about',
                'content' => 'We promote cycling sports across Tanzania, organizing races and events for all levels.',
                'sections' => [],
            ],
            [
                'title' => 'Gallery',
                'subtitle' => 'Capturing the energy and spirit of cycling',
                'slug' => 'gallery',
                'content' => 'Explore our collection of photos from various cycling events.',
                'sections' => [],
            ],
            [
                'title' => 'Contact Us',
                'subtitle' => 'Get In Touch',
                'slug' => 'contact',
                'content' => 'Have questions? We\'d love to hear from you.',
                'sections' => [],
            ],
        ];

        foreach ($pages as $page) {
            ContentPage::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
