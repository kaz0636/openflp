<?php
class MembersController extends AppController
{
    public $uses = array('Member');

    public function beforeFilter()
    {
    }

    public function create()
    {
        if (!$this->isPOST()) {
            $this->pageTitle = 'Create new account';
            return $this->render(null, 'default', 'new');
        }

        $data = array(
            'username' => $this->params('username'),
            'password' => $this->params('password'),
            'password_confirmation' => $this->params('password_confirmation'),
        );
        $this->Member->set($data);
        if (!$this->Member->save()) {
            return $this->render(null, 'default', 'new');
        }

        $this->Flash->notice('Thanks for signing up!');
        $this->redirect('/');
    }
}
