<?php
App::import('Core', 'String');
App::import('vendor', 'FeedUtils');
Configure::write('Database.logSQL', 0); 

class CrawlerShell extends Shell
{
    public $uses = array('CrawlStatus', 'Feed', 'Subscription', 'Item');

    const ITEMS_LIMIT = 500;
    const CRAWL_LIMIT = 5;
    const CRAWL_INTERVAL = '-30 min';

    // crawl status
    const CRAWL_OK = 1;
    const CRAWL_NOW = 10;

    public function main()
    {
        $this->log('start:'.date('Y-m-d H:i:s'), LOG_INFO);

        for ($i = 0; $i < self::CRAWL_LIMIT; $i++) {
            $this->updateCrawlStatus();
            $data = $this->fetchCrawlStatus();
            if (!$data) continue;
            $result = $this->crawl($data);
            if ($result['error'] == 0) {
                $this->log("success: {$result['message']}", LOG_INFO);
            } else {
                $this->log("error: {$result['message']}", LOG_INFO);
            }
            $data['CrawlStatus']['status'] = self::CRAWL_OK;
            $data['CrawlStatus']['http_status'] = 200; // FIXME: SimplePie doesn't return status code..
            $this->CrawlStatus->set($data);
            $this->CrawlStatus->save();
        }

        $this->log('end:'.date('Y-m-d H:i:s'), LOG_INFO);
    }

    public function updateCrawlStatus()
    {
        $conditions = array();
        $conditions[] = es('CrawlStatus.crawled_on < %s', date_create('-1 day')->format('Y-m-d H:i:s'));
        $this->CrawlStatus->updateAll(array('status' => self::CRAWL_OK), $conditions);
    }

    public function fetchCrawlStatus()
    {
        $conditions = array();
        $conditions[] = es('CrawlStatus.status = %s', self::CRAWL_OK);
        $conditions[] = es('Feed.subscribers_count > 0');
        $conditions[] = es('CrawlStatus.crawled_on IS NULL OR CrawlStatus.crawled_on < %s', date_create(self::CRAWL_INTERVAL)->format('Y-m-d H:i:s'));
        $order = 'CrawlStatus.crawled_on ASC';
        $r = $this->CrawlStatus->find($conditions, null, $order);
        if ($r) {
            $r['CrawlStatus']['status'] = self::CRAWL_NOW;
            $r['CrawlStatus']['crawled_on'] = date('Y-m-d H:i:s');
            $this->CrawlStatus->set($r);
            $r = $this->CrawlStatus->save();
        }
        return $r;
    }

    public function crawl($data)
    {
        $result = array(
            'new_items' => 0,
            'updated_items' => 0,
            'error' => null,
        );

        $feed = FeedUtils::getFeed($data['Feed']['feedlink']);
        if ($feed->error()) {
            $result['message'] = $feed->error();
            $result['error'] = 1;
            return $result;
        }

        $items = $feed->get_items();

        if (count($items) > self::ITEMS_LIMIT) {
            $this->log("too large feed: {$data['Feed']['feedlink']}".'('.count($items).')', LOG_INFO);
            array_splice($items, self::ITEMS_LIMIT);
        }

        // update items

        foreach ($items as $k => $item) {
            $r = array(
                'Item' => array(
                    'feed_id' => $data['Feed']['id'],
                    'link' => $item->get_link(),
                    'title' => $item->get_title(),
                    'body' => $item->get_content(),
                    'author' => $item->get_author(),
                    'category' => $item->get_category(),
                    'enclosure' => null,
                    'enclosure_type' => null,
                    'digest' => $this->itemDigest($item->get_title(), $item->get_content()),
                    'stored_on' => date('Y-m-d H:i:s'),
                    'modified_on' => $item->get_date('Y-m-d H:i:s'),
                ),
            );
            $items[$k] = $r;
        }

        foreach ($items as $k => $item) {
            $conditions = array();
            $conditions[] = es('Feed.id = %s', $data['Feed']['id']);
            $conditions[] = es('Item.title = %s', $item['Item']['title']);
            $conditions[] = es('Item.link = %s', $item['Item']['link']);
            $r = $this->Item->find($conditions);
            if ($r) {
                unset($items[$k]);
            }
        }

        foreach ($items as $k => $item) {
            $conditions = array();
            $conditions[] = es('Feed.id = %s', $data['Feed']['id']);
            $conditions[] = es('Item.link = %s', $item['Item']['link']);
            $old_item = $this->Item->find($conditions);
            if ($old_item) {
                $same_title = $this->almostSame($old_item['Item']['title'], $item['Item']['title']);
                $same_body = $this->almostSame($old_item['Item']['body'], $item['Item']['body']);
                if (!$same_title || !$same_body) {
                    $result['updated_items']++;
                }
                $item['Item'] = array_merge($old_item['Item'], $item['Item']);
                $this->Item->set($item);
                $this->Item->save();
            } else {
                $result['new_items']++;
                $this->Item->create($item);
                $this->Item->save();
            }
        }

        // update subscriptions
        if ($result['new_items'] + $result['updated_items'] > 0) {
            $data['Feed']['modified_on'] = date('Y-m-d H:i:s');
            $conditions = array();
            $conditions[] = es('Subscription.feed_id = %s', $data['Feed']['id']);
            $this->Subscription->updateAll(array('has_unread' => true), $conditions);
        }

        // update feed
        $new_feed = array(
            'title' => $feed->get_title(),
            'link' => $feed->get_link(),
            'description' => $feed->get_description(),
            'image' => null,
        );
        $data['Feed'] = array_merge($data['Feed'], $new_feed);
        $this->Feed->set($data['Feed']);
        $this->Feed->save();

        $result['message'] = "{$result['new_items']} new items, {$result['updated_items']} updated items";

        return $result;
    }

    public function itemDigest($title, $content)
    {
        $s = $title . $content;
        $s = preg_replace('@<br clear="all"\s*/>\s*<a href="http://rss\.rssad\.jp/(.*?)</a>\s*<br\s*/>@im', '', $s);
        $s = preg_replace('@\s+@', '', $s);
        return sha1($s);
    }

    public function almostSame($str1, $str2)
    {
        if ($str1 === $str2) {
            return true;
        }
        $chars1 = str_split($str1);
        $chars2 = str_split($str2);
        if (count($chars1) != count($chars2)) {
            return false;
        }
        $d = 0;
        for ($i = 0; $i < count($chars1); $i++) { 
            if ($chars1[$i] != $chars2[$i]) $d++;
        }
        return $d;
    }

    public function log($msg, $type)
    {
        $msg = '[CrawlerShell] ' . $msg;
        return parent::log($msg, $type);
    }
}
