<?php
class DirFixture extends CakeTestFixture
{
    public $name = 'Dir';
    public $table = 'folders';
    public $import = array('table' => 'folders', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
                'member_id' => 1,
                'name' => 'test',
            ),
            array(
                'id' => 2,
                'member_id' => 1,
                'name' => 'test2',
            ),
        );
    }
}
