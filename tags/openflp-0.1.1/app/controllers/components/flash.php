<?php
class FlashComponent extends Object
{
    public $components = array('Session');

    const FLASH_NOTICE = 'flash_notice';

    public function startup(&$controller)
    {
        $controller->set('Flash', $this);
    }

    public function notice($msg = '')
    {
        if ($msg) {
            $this->Session->write(self::FLASH_NOTICE, $msg);
            return true;
        } else {
            return $this->Session->read(self::FLASH_NOTICE);
        }
    }

    public function shutdown(&$controller)
    {
        $this->Session->delete(self::FLASH_NOTICE);
    }
}
