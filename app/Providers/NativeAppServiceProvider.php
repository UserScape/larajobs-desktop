<?php

namespace App\Providers;

use Config;
use Native\Laravel\Enums\RolesEnum;
use Native\Laravel\Facades\GlobalShortcut;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Window;
use Native\Laravel\Menu\Items\Role;
use Native\Laravel\Menu\Menu;

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
                    ->separator()
                    ->link('https://larajobs.com', 'View LaraJobs.com', 'CmdOrCtrl+L')
                    ->link('https://larajobs.com/create', 'Post a Job', 'CmdOrCtrl+P')
                    ->link('https://larajobs.com/laravel-consultants', 'Hire a Laravel Consultant', 'CmdOrCtrl+H')
                    ->separator()
                    ->add(new Role(RolesEnum::QUIT, 'Quit ' . Config::get('app.name', 'LaraJobs Desktop'))
            )
        );

        // @TODO: Figure out why this doesn't work
        GlobalShortcut::key('CmdOrCtrl+Shift+J')
            ->event(\App\Events\HandleGlobalShortcutRefresh::class)
            ->register();

        // For debugging
        if (Config::get('app.debug', false)) {
            // Window::open()->alwaysOnTop();
        }
    }
}
