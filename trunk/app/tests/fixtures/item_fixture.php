<?php
class ItemFixture extends CakeTestFixture
{
    public $name = 'Item';
    public $import = array('table' => 'items', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
                'feed_id' => 1,
                'link' => 'http://example.com/article/1',
            ),
            array(
                'id' => 2,
                'feed_id' => 1,
                'link' => 'http://example.com/article/2',
            ),
        );
    }
}
