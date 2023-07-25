<?php

namespace App\Utility;

class WatchingDataUtility
{
    /**
     * Get watching data from database
     *
     * @return Array
     */
    public static function getWatching(): Array {
        try {
            $watching = file_get_contents(database_path('watching.json'));
            $watching = json_decode($watching, true);
            if (!isset($watching['tags'])) {
                $watching['tags'] = [];
            }
            if (!isset($watching['salary'])) {
                $watching['salary'] = [
                    'min' => null,
                    'currency' => null,
                ];
            }
            if (!isset($watching['full_time'])) {
                $watching['full_time'] = null;
            }
        } catch (\Throwable) {
            $watching = [
                'tags' => [],
                'salary' => [
                    'min' => null,
                    'currency' => null,
                ],
                'full_time' => null
            ];
            file_put_contents(database_path('watching.json'), json_encode($watching));
        }
        return $watching;
    }

    /**
     * Set watching data to database
     *
     * @param array $watching
     * @return void
     */
    public static function setWatching(array $watching): void {
        file_put_contents(database_path('watching.json'), json_encode($watching, JSON_PRETTY_PRINT));
    }
}
