<?php
class DATABASE_CONFIG {
    var $default = array(
        'driver' => 'mysql_ext',
        'persistent' => false,
        'host' => 'localhost',
        'port' => '',
        'login' => 'fastladder',
        'password' => 'fastladder',
        'database' => 'fastladder',
        'schema' => '',
        'prefix' => '',
        'encoding' => ''
    );
    var $test = array(
        'driver' => 'mysql_ext',
        'persistent' => false,
        'host' => 'localhost',
        'port' => '',
        'login' => 'fastladder',
        'password' => 'fastladder',
        'database' => 'fastladder_test',
        'schema' => '',
        'prefix' => 'test_suite',
        'encoding' => ''
    );
}
?>
