<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use SimpleXMLElement;

/**
 * This service is responsible for retrieving data from the RSS feed.
 */
class RSSDataService
{
    public function get(): SimpleXMLElement
    {
        $xml = file_get_contents(Config::get('larajobs.feed_url'));

        return new SimpleXMLElement($xml);
    }
}
