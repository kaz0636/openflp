<?php
require_once 'simplepie/simplepie.inc';
class FeedUtils
{
    static function getFeedlinks($url)
    {
        if (!is_string($url)) return false;
        $parsed = @parse_url($url);
        if (empty($parsed['scheme'])) {
            return false;
        }
        if (!in_array($parsed['scheme'], array('http', 'https'))) {
            return false;
        }

        $timeout = 10;
        $redirects = 5;
        $headers = null;
        $useragent = null;
        $file = new SimplePie_File($url, $timeout, $redirects, $headers, $useragent);
        $locator = new SimplePie_Locator($file, $timeout, $useragent);

        $r = $locator->find();
        return !empty($r->url) ? array($r->url) : false;
    }

    /**
     * see http://simplepie.org/wiki/reference/start#simplepie_item
     *
     * @return array SimplePie_Item
     */
    static function getFeed($url)
    {
        $feed = new SimplePie;
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();
        return $feed;
    }
}
