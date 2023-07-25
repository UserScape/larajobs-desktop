<?php

return [
    'feed' => [
        'url' => env('LARAJOBS_FEED_URL', 'https://larajobs.com/feed'),
    ],
    'website' => [
        'url' => env('LARAJOBS_WEBSITE_URL', 'https://larajobs.com'),
    ],
    'ui' => [
        'menu-bar' => [
            'view' => [
                'width' => env('LARAJOBS_UI_MENU_BAR_VIEW_WIDTH', '512'),
                'height' => env('LARAJOBS_UI_MENU_BAR_VIEW_HEIGHT', '448'),
            ],
        ],
    ],
];
