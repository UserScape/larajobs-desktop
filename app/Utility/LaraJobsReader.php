<?php
namespace App\Utility;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

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
        // cache the RSS feed for 15 minutes
        $this->items = Cache::remember('lara-jobs', 60 * 15, function () {
            return $this->fresh();
        });
    }

    /**
     * Get fresh copy of the RSS feed
     *
     * @return void
     */
    private function fresh() {
        $feed = new RssFeedLoader("https://larajobs.com/feed-test");
        $data = $feed->getItemsWithAllNamespaces();

        return array_map(function ($item) {
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

    /**
     * Get matching items from the RSS feed
     *
     * @return array
     */
    public function getMatchingItems(): array {
        $userPreferences = WatchingDataUtility::getWatching();

        $matchingJobs = array_filter($this->items, function ($job) use ($userPreferences) {
            $matching = $this->doesJobMatch($job, $userPreferences);
            return $matching;
        });

        return $matchingJobs;
    }

    /**
     * Check if the job matches the user preferences
     *
     * @param array $job
     * @param array $userPreferences
     * @return boolean
     */
    private function doesJobMatch(array $job, array $userPreferences): bool {
        if ($userPreferences['full_time'] && $job['job_type'] !== 'FULL_TIME') {
            return false;
        }
        if ($job['salary']['currency'] && $userPreferences['salary']['currency'] !== $job['salary']['currency']) {
            return false;
        }
        if (isset($job['salary']['range'][0])) {
            $userAnnualRate = $userPreferences['salary']['min'] * 40 * 52;
            $jobAnnualRate = $job['salary']['hourly'] ? $job['salary']['range'][0] * 40 * 52 : $job['salary']['range'][0];
            if ($userAnnualRate > $jobAnnualRate) {
                return false;
            }

        }
        if (count($userPreferences['tags']) > 0 && count($job['tags']) > 0) {
            $jobTags = array_map(function ($tag) {
                return strtolower(trim($tag));
            }, $job['tags']);
            $userTags = array_map(function ($tag) {
                return strtolower(trim($tag));
            }, $userPreferences['tags']);
            $matchingTags = array_intersect($jobTags, $userTags);
            if (count($matchingTags) === 0) {
                return false;
            }
        }

        return true;
    }
}
