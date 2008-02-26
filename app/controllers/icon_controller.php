<?php
class IconController extends AppController
{
    public $uses = null;
    public $layout = null;

    public function get()
    {
        $feed = $this->params('feed');

        // TODO: favicon support

        Configure::write('debug', 0);

        $filename = DEFAULT_FAVICON;
        if (!file_exists($filename)) {
            die();
        }

        header('Content-Type: image/png');
        readfile($filename);
    }
}    
