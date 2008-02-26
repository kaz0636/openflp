<?php
class PinFixture extends CakeTestFixture
{
    public $name = 'Pin';
    public $import = array('table' => 'pins', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
                'member_id' => 1,
                'link' => 'http://example.com/article/1',
            ),
            array(
                'id' => 2,
                'member_id' => 1,
                'link' => 'http://example.com/article/2',
            ),
        );
    }
}
