<?php
App::import('vendor', 'cake_test_case_ext');
App::import('Model', 'Subscription');

class SubscriptionTestCase extends CakeTestCaseExt
{
    public $fixtures = array(
        'crawl_status', 'favicon', 'feed',  'dir',
        'item', 'member', 'pin', 'subscription',
    );

    public function startTest($method)
    {
        $this->Subscription = new Subscription;
    }

    public function endTest($method)
    {
        unset($this->Subscription);
    }

    public function test_true()
    {
        $this->assertTrue(true);
    }

    public function test_read()
    {
        $r = $this->Subscription->read(null, 1);
        pr($r);
        $this->assertTrue(is_array($r['Member']));
        $this->assertTrue(is_array($r['Feed']));
        $this->assertTrue(is_array($r['Dir']));
    }

}
