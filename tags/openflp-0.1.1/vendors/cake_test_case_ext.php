<?php
Configure::write('Database.useDbConfig', 'test');

class CakeTestCaseExt extends CakeTestCase
{
    public function before($method)
    {
        Configure::write('Database.logSQL', 0);
        $msg = sprintf('(%s::%s)', get_class($this), $method);
        CakeLog::write(LOG_INFO, $msg);
        parent::before($method);
        Configure::write('Database.logSQL', 2);
    }

    public function after($method)
    {
        Configure::write('Database.logSQL', 0);
        parent::after($method);
        Configure::write('Database.logSQL', 2);
    }

    public function end()
    {
        Configure::write('Database.logSQL', 0);
        parent::end();
        Configure::write('Database.logSQL', 2);
    }

}
