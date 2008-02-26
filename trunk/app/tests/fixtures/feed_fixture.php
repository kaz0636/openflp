<?php
class FeedFixture extends CakeTestFixture
{
    public $name = 'Feed';
    public $import = array('table' => 'feeds');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
                'feedlink' => 'http://example.com/rss1',
                'subscribers_count' => 16,
            ),
            array(
                'id' => 2,
                'feedlink' => 'http://example.com/rss2',
                'subscribers_count' => 32,
            ),
        );
    }
}
