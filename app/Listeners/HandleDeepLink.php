<?php

namespace App\Listeners;

use Joli\JoliNotif\Notification as JoliNotification;
use Joli\JoliNotif\NotifierFactory;

use Native\Laravel\Client\Client;
use Native\Laravel\Events\App\OpenedFromURL;
use Native\Laravel\Notification;

use Illuminate\Support\Str;

class HandleDeepLink
{
    /**
     * Handle the event.
     */
    public function handle(OpenedFromURL $event): void
    {
        $prefix = config('nativephp.deeplink_scheme').'://';
        if (!Str::startsWith($event->url, $prefix)) {
            return;
        }

        $method = 'handle' . ucfirst(Str::after($event->url, $prefix));
        if (method_exists($this, $method)) {
            $this->{$method}($event);
        }

        ray([
            'event' => $event,
            'method' => $method,
        ]);
    }

    public function handleNotifyNative(OpenedFromURL $event): void
    {
        $title = "Test Notification";
        $message = "This is a test notification.";

        $client = new Client();
        $notification = new Notification($client);

        $notification->title($title . uniqid())
            ->message($message)
            ->event('test')
            ->show();

        ray($notification);
    }

    public function handleNotifyJoli(OpenedFromURL $event): void
    {
        $title = "Test Notification";
        $message = "This is a test notification.";

        $notifier = NotifierFactory::create();
        $notification = (new JoliNotification())
            ->setTitle($title . uniqid())
            ->setBody($message)
            ->setIcon(public_path('/images/menuBarIconTemplate@2x.png'));

        $notifier->send($notification);
    }
}