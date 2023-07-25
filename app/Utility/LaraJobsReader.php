<?php
namespace App\Utility;

/**
* Class LaraJobsReader
*
* This class handles the extraction of salary range, currency and time period from a given string.
*/
class LaraJobsReader
{
    private $items;

    public function __construct()
    {
        $feed = new RssFeedLoader("https://larajobs.com/feed");
        $data = $feed->getItemsWithAllNamespaces();

        // replace all array keys with colon removed
        $this->items = array_map(function ($item) {
            $newItem = [];
            // remove the namespace from the key
            foreach ($item as $key => $value) {
                $key = str_replace('job:', '', $key);
                $key = str_replace('dc:', '', $key);
                $newItem[$key] = $value;
            }
            // explode tags into array
            $newItem['tags'] = explode(',', $newItem['tags']);

            // convert salary to array
            $salary = (new SalaryRange($newItem['salary']));
            $newItem['salary'] = [
                'raw' => $newItem['salary'],
                'range' => $salary->range,
                'hourly' => $salary->hourly,
                'currency' => $salary->currency,
            ];

            return $newItem;
        }, $data);
    }

    /**
     * Get all items from the RSS feed
     *
     * @return array
     */
    public function getItems(): array {
        return $this->items;
    }
}
