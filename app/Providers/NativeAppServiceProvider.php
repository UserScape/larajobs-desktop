<?php

namespace App\Providers;

use Native\Laravel\Facades\ContextMenu;
use Native\Laravel\Facades\Dock;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Window;
use Native\Laravel\GlobalShortcut;
use Native\Laravel\Menu\Menu;
use SimpleXMLElement;

class NativeAppServiceProvider
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        MenuBar::create()
            ->route('list')
            ->showDockIcon()
            ->withContextMenu(
                Menu::new()
                    ->link('#', 'Refresh', 'CmdOrCtrl+R')
                    ->separator()
                    ->quit()
            );
    }
}
