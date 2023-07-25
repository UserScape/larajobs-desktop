<?php
namespace App\Utility;

use Exception;
use Illuminate\Support\Facades\Cache;
use SimpleXMLElement;

/**
 * Rss feed loader
 */
class RssFeedLoader {
    /**
     * URL of the RSS feed.
     *
     * @var string
     */
    private $url;

    /**
     * The constructor accepts the URL of the RSS feed.
     *
     * @param string $url
     */
    public function __construct(string $url) {
        $this->url = $url;

        $this->load();
    }

    /**
     * Load the RSS feed and convert it to a SimpleXMLElement object.
     *
     * @return SimpleXMLElement The loaded RSS feed.
     * @throws Exception If the RSS feed could not be loaded.
     */
    private function load(): SimpleXMLElement {
        $data = Cache::remember('rss-feed', 60, function () {
            return file_get_contents($this->url);
        });
        $rss = simplexml_load_string($data);
        if (!$rss) {
            throw new Exception('Could not load RSS feed');
        }
        return $rss;
    }

    /**
     * Get all items from the RSS feed, including those in namespaces.
     *
     * @return array An array of all items, each item is an associative array where each key is a field name.
     */
    public function getItemsWithAllNamespaces(): array {
        // Load the RSS feed
        $rss = $this->load();
        // Get all namespaces in the feed
        $namespaces = $rss->getNamespaces(true);

        // Array to hold all items
        $items = [];
        // Loop over each item in the feed
        foreach ($rss->channel->item as $originalItem) {
            // Array to hold the fields of a single item
            $itemArr = [];
            // Loop over each namespace
            foreach ($namespaces as $prefix => $ns) {
                // Get all fields in this namespace
                $item = $originalItem->children($ns);
                // Loop over each field
                foreach ($item as $key => $value) {
                    // Add the field to the item array, with the key in the format 'namespace:field'
                    $itemArr[$prefix . ':' . $key] = (string) $value;
                }
            }
            // Also get the standard fields (those not in a namespace)
            foreach ($originalItem as $key => $value) {
                $itemArr[$key] = (string) $value;
            }
            // Add the item to the items array
            $items[] = $itemArr;
        }
        // Return all items
        return $items;
    }
}
?>
