<?php
class UtilityBookmarkletController extends AppController
{
    public $uses = null;

    public function index()
    {
        $file = VIEWS.'utility/bookmarklet/index.ctp';
        $this->render(null, $this->layout, $file);
    }
}

