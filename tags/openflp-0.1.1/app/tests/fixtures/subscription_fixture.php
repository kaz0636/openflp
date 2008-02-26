<?php
class SubscriptionFixture extends CakeTestFixture
{
    public $name = 'Subscription';
    public $import = array('table' => 'subscriptions', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
                'member_id' => 1,
                'feed_id' => 1,
            ),
            array(
                'id' => 2,
                'member_id' => 1,
                'feed_id' => 2,
            ),
        );
    }
}
