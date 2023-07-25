<?php

namespace App\Providers;

use Native\Laravel\Facades\ContextMenu;
use Native\Laravel\Facades\Dock;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Window;
use Native\Laravel\GlobalShortcut;
use Native\Laravel\Menu\Menu;

class NativeAppServiceProvider
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        MenuBar::create()
            ->icon(resource_path('ai/menuBarIconTemplate.png'));
        Menu::new()
            ->appMenu()
            ->viewMenu()
            ->submenu('About', Menu::new()
                ->link('https://larajobs.com', 'Larajobs')
                ->separator()
                ->link('https://github.com/sawirricardo', 'Ricardo Sawir')
                ->link('https://sawirstudio.com', 'SawirStudio')
                ->separator()
                ->quit()
            )
            ->register();

        // Window::open()
        //     ->width(800)
        //     ->height(800);

        /**
            Dock::menu(
                Menu::new()
                    ->event(DockItemClicked::class, 'Settings')
                    ->submenu('Help',
                        Menu::new()
                            ->event(DockItemClicked::class, 'About')
                            ->event(DockItemClicked::class, 'Learn More…')
                    )
            );

            ContextMenu::register(
                Menu::new()
                    ->event(ContextMenuClicked::class, 'Do something')
            );

            GlobalShortcut::new()
                ->key('CmdOrCtrl+Shift+I')
                ->event(ShortcutPressed::class)
                ->register();
        */
    }
}
