<?php

namespace App\Services;

use SimplePie\SimplePie;

class LarajobsService
{
    public function feedItems()
    {
        return $this->simplePie()->get_items();
    }

    public function simplePie(): SimplePie
    {
        $simplePie = new SimplePie;
        $simplePie->set_feed_url('https://larajobs.com/feed-test');
        $simplePie->set_cache(cache()->driver());
        $simplePie->init();
        return $simplePie;
    }
}
