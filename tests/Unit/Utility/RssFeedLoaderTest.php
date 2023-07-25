<?php

namespace Tests\Unit\Utility;

use App\Utility\RssFeedLoader;
use Tests\TestCase;

class RssFeedLoaderTest extends TestCase {

    /**
     * Test loading the RSS feed.
     *
     * @return void
     */
    public function testLoad() {
        $loader = new RssFeedLoader('https://larajobs.com/feed-test');
        $rss = $loader->load();
        $this->assertInstanceOf(SimpleXMLElement::class, $rss);
    }

    /**
     * Test getting all items from the RSS feed, including those in namespaces.
     *
     * @return void
     */
    public function testGetItemsWithAllNamespaces() {
        $loader = new RssFeedLoader('https://larajobs.com/feed-test');
        $items = $loader->getItemsWithAllNamespaces();
        dd($items);
        $this->assertIsArray($items);
        if (count($items) > 0) {
            $this->assertArrayHasKey('dc:creator', $items[0]);
            $this->assertArrayHasKey('job:location', $items[0]);
            $this->assertArrayHasKey('job:job_type', $items[0]);
            $this->assertArrayHasKey('job:salary', $items[0]);
            $this->assertArrayHasKey('job:company', $items[0]);
            $this->assertArrayHasKey('job:company_logo', $items[0]);
            $this->assertArrayHasKey('job:tags', $items[0]);
        }
    }
}

?>
