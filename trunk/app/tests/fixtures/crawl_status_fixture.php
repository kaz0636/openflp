<?php
class CrawlStatusFixture extends CakeTestFixture
{
    public $name = 'CrawlStatus';
    public $import = array('table' => 'crawl_statuses', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $this->records = array(
            array(
                'id' => 1,
            ),
            array(
                'id' => 2,
            ),
        );
    }
}
