<?php
class ReaderController extends AppController
{
    public $uses = null;
    public $layout = null;

    public function welcome()
    {
        if (!$this->member->id) {
            $this->redirect('/login');
        }
        $this->redirect('/reader/index');
    }

    public function index()
    {
    }
}
