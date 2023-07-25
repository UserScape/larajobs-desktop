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
                $items = collect($channel)->map(function (Rss $item) {
                    $xpath = $item->getXpath();

                    $location = $xpath->evaluate('string(//job:location)');
                    $remote = str($location)->match('/remote/i')->isNotEmpty();
                    $tags = str($xpath->evaluate('string(//job:tags)'))->explode(',');

                    $logoUrl = $xpath->evaluate('string(//job:company_logo)');
                    $logo = isValidImageUrl($logoUrl) ? $logoUrl : null;

                    $fulltime = str($xpath->evaluate('string(//job:job_type)'))->isNotEmpty();
                    $salary = $xpath->evaluate('string(//job:salary)');
                    $salary = $salary ?? null;

                    return [
                        'guid' => $item->getId(),
                        'title' => $item->getTitle(),
                        'url' => $item->getPermaLink(),
                        'published_at' => $item->getDateModified()->format('Y-m-d H:i:s'),
                        'company' => $xpath->evaluate('string(//job:company)'),
                        'logo' => $logo,
                        'remote' => $remote,
                        'location' => $location,
                        'fulltime' => $fulltime,
                        'salary' => $salary,
                        'tags' => $tags,
                    ];
                });

                Jobs::upsert($items->toArray(), ['guid'], ['title', 'url', 'published_at', 'company', 'logo', 'remote', 'location', 'tags']);

                return $items;
            });
        });
    }

    private function createNewFeedWithReader()
    {
        return Reader::import($this->url);
    }
}
