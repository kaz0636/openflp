<?php
class FaviconFixture extends CakeTestFixture
{
    public $name = 'Favicon';
    public $import = array('table' => 'favicons', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
                'feed_id' => 1,
            ),
            array(
                'id' => 2,
                'feed_id' => 2,
            ),
        );
    }
}
