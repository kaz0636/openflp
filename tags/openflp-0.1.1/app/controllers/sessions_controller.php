<?php
class SessionsController extends AppController
{
    public $uses = array('Member');

    public function beforeFilter()
    {
    }

    public function create()
    {
        if ($this->Member->findCount() == 0) {
            $this->redirect('/signup');
        }

        if ($this->isPOST()) {
            $member = $this->Member->authenticate(
                $this->params('username'),
                $this->params('password')
            );
            if ($member) {
                $this->Member->set($member);
                if ($this->params('remember_me') == 1) {
                    /*
                    FIXME:
                    $this->Member->rememberMe();
                    cookie :auth_token
                    */
                }

                $this->Session->renew();
                $this->Session->write('member_id', $this->Member->id);
                $this->Flash->notice('Signed in successfully');
                $this->redirect('/');

            } else {
                $this->Flash->notice('Cannot sign in');
            }
        }

        $this->render(null, 'default', 'new');
    }

    public function destroy()
    {
        $this->Session->destroy();
        $this->redirect('/');
    }
}
