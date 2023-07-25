<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

function isValidImageUrl($url)
{
    Log::info('isValidImageUrl: '.$url);

    $validExtensions = ['gif', 'jpg', 'jpeg', 'png'];

    if (! Str::startsWith($url, ['http://', 'https://'])) {
        return false;
    }

    $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));

    if (! in_array($extension, $validExtensions)) {
        return false;
    }

    return true;
}
