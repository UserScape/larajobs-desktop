<?php

namespace App\Providers;

use Config;
use Native\Laravel\Enums\RolesEnum;
use Native\Laravel\Menu\Menu;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Menu\Items\Role;

class NativeAppServiceProvider
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        $deepLinkPrefix = config('nativephp.deeplink_scheme') . '://';
        MenuBar::create()
            ->icon(public_path('images/menuBarIconTemplate@2x.png'))
            ->route('menubar.index')->withContextMenu(
                Menu::new()
                    ->link("{$deepLinkPrefix}refresh", 'Refresh', 'CmdOrCtrl+R')
                    ->link("{$deepLinkPrefix}notify", 'Test Notifications', 'CmdOrCtrl+N')
                    ->separator()
                    ->link('https://larajobs.com', 'View LaraJobs.com')
                    ->link('https://larajobs.com/create', 'Post a Job')
                    ->link('https://larajobs.com/laravel-consultants', 'Hire a Laravel Consultant')
                    ->separator()
                    ->add(new Role(RolesEnum::QUIT, 'Quit ' . Config::get('app.name', 'LaraJobs Desktop'))
            )
        );
    }
}
