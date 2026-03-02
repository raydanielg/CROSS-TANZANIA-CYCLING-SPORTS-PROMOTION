<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AdminLteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $user = auth()->user();
            if ($user) {
                $event->menu->addAfter('search', [
                    'text' => $user->name,
                    'url'  => 'admin/users/profile',
                    'image' => $user->profile_photo_url,
                    'topnav_user' => true,
                ]);
            }
        });
    }
}
