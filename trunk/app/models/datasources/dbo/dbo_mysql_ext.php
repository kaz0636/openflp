<?php
uses('model'.DS.'datasources'.DS.'dbo'.DS.'dbo_mysql');

Configure::write('Database.instanceId', mt_rand(100, 999));

function es($query, $args = null) 
{
    $args = func_get_args();
    array_shift($args);
    foreach ($args as $k => $v) {
        $v = mysql_real_escape_string($v);
        $args[$k] = "'{$v}'";
    }
    return vsprintf($query, $args); 
}

class DboMysqlExt extends DboMysql
{
    public $queryNo = 1;

    public function _execute($sql)
    {
        $r = mysql_query($sql, $this->connection);
        $instance_id = Configure::read('Database.instanceId');

        switch(Configure::read('Database.logSQL')) {
        case 2:
            $this->log(sprintf("%s:%d:(%s) %s", $instance_id, $this->queryNo, $this->config['database'], $sql), LOG_DEBUG);
            break;
        case 1:
            if ($this->isIgnoredQuery($sql)) break;
            $this->log(sprintf("%s:%d:(%s) %s", $instance_id, $this->queryNo, $this->config['database'], $sql), LOG_DEBUG);
            break;
        default:
            break;
        }

        $this->queryNo++;
        return $r;
    }

    protected function isIgnoredQuery($sql)
    {
        $ignore_list = array('SELECT', 'DESC');

        foreach ($ignore_list as $v) {
            if (stripos($sql, $v) === 0) return true;
        }       

        return false;
    }
}
