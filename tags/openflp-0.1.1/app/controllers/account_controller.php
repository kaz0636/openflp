<?php
class AccountController extends AppController
{
    public $uses = array('Member');

    public function index()
    {
    }

    public function password()
    {
        if ($this->isPOST()) {
            $member = Member::isAuthenticated(
                $this->member->data['Member']['crypted_password'],
                $this->params('password'),
                $this->member->data['Member']['salt']
            );
            if (!$member) {
                // add error msg: $password is invalid
                return;
            }
            
            if ($this->params('new_password') !== $this->params('new_password_confirmation')) {
                // add error msg: Password doesn't match confirmation
                return;
            }

            $this->member->data['Member']['crypted_password'] = '';
            $this->member->data['Member']['password'] = $this->params('new_password');
            $this->member->save();
        }
    }

    public function backup()
    {
    }

    public function share()
    {
    }
}    
