<?php

namespace App\Services;

use App\Models\Jobs;
use Laminas\Feed\Reader\Entry\Rss;
use Laminas\Feed\Reader\Reader;

class FeedService
{
    private string $url;

    private string $reader = Reader::class;

    public function __construct($url)
    {
        $this->url = $url;
        $this->reader::setHttpClient(new GuzzleClient());
    }

    public function refresh()
    {
        return rescue(function () {
            return retry(3, function () {
                $channel = $this->createNewFeedWithReader();
                $items = collect($channel)->map(fn (Rss $item) => [
                    'title' => $item->getTitle(),
                    'url' => $item->getLink(),
                    'published_at' => $item->getDateModified()->format('Y-m-d H:i:s'),
                    'creator' => $item->getAuthor()['name'],
                    'guid' => $item->getId(),
                ]);
                Jobs::upsert($items->toArray(), ['guid'], ['title', 'url', 'published_at', 'creator', 'guid']);
                return $items;
            });
        });
    }

    private function createNewFeedWithReader()
    {
        return Reader::import($this->url);
    }
}
