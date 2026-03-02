<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Cycling News', 'slug' => 'cycling-news', 'description' => 'Latest updates from the cycling world.'],
            ['name' => 'Training Tips', 'slug' => 'training-tips', 'description' => 'Improve your cycling performance.'],
            ['name' => 'Event Updates', 'slug' => 'event-updates', 'description' => 'Official updates regarding CT-CSP events.'],
        ];

        foreach ($categories as $cat) {
            $category = \App\Models\BlogCategory::create($cat);

            // Sub Categories
            \App\Models\BlogSubCategory::create([
                'blog_category_id' => $category->id,
                'name' => 'General ' . $cat['name'],
                'slug' => 'general-' . $cat['slug'],
            ]);
        }

        $user = \App\Models\User::first();
        $cat = \App\Models\BlogCategory::first();

        $post = \App\Models\BlogPost::create([
            'user_id' => $user->id,
            'blog_category_id' => $cat->id,
            'title' => 'Welcome to Cross Tanzania Blog',
            'slug' => 'welcome-to-cross-tanzania-blog',
            'summary' => 'We are excited to launch our new blog for cycling enthusiasts.',
            'content' => '<p>This is the first post on our new platform. Stay tuned for more!</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        \App\Models\BlogComment::create([
            'blog_post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Great to see this blog live!',
            'is_approved' => true,
        ]);
    }
}
