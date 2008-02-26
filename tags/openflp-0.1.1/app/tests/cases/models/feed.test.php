<?php
App::import('vendor', 'cake_test_case_ext');
App::import('Model', 'Feed');

class FeedTestCase extends CakeTestCaseExt
{
    public $fixtures = array(
        'crawl_status', 'favicon', 'feed',  'dir',
        'item', 'member', 'pin', 'subscription',
    );

    public function startTest($method)
    {
        $this->Feed = new Feed;
    }

    public function endTest($method)
    {
        unset($this->Feed);
    }

    public function test_true()
    {
        $this->assertTrue(true);
    }

    public function test_read()
    {
        $r = $this->Feed->read(null, 1);
        pr($r);
        $this->assertTrue(is_array($r['Feed']));
        $this->assertTrue(is_array($r['CrawlStatus']));
        $this->assertTrue(is_array($r['Favicon']));
    }

    public function test_icon()
    {
        $r = array();
        $this->assertEqual($this->Feed->icon($r), '/img/icon/default.png');

        $r = array(
            'Feed' => array('id' => 2),
            'Favicon' => array('id' => 1),
        );
        $this->assertEqual($this->Feed->icon($r), '/icon/2');
    }

    public function test_updateSubscribersCount()
    {
        $r = $this->Feed->read(null, 1);
        $this->assertEqual($r['Feed']['subscribers_count'], 16);

        $this->Feed->updateSubscribersCount($r);

        $r = $this->Feed->read(null, 1);
        $this->assertEqual($r['Feed']['subscribers_count'], 1);
    }

    /*
    public function test_test()
    {
        $r = $this->Feed->id = 1;
        $r = $this->Feed->Subscriptions->findById(1);
        pr($r);
    }
    */
}
