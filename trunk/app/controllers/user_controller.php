<?php
class UserController extends AppController
{
    public $uses = array('Member');

    public function index()
    {
        $login_name = $this->params('login_name');
        $target = $this->Member->findByUsername($login_name);
        $this->set('target', $target);
    }

    public function rss()
    {
        // FIXME: not supported..
    }

    public function opml()
    {
        // FIXME: not supported..
    }

} 
