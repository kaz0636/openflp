<?php
App::import('Model', 'Member');
class AppController extends Controller
{
    public $components = array('Session', 'Flash');
    public $helpers = array('Html', 'Form', 'Basics');
    protected $member; // instance of logged in member

    public function beforeFilter()
    {
        $this->setMember();
    }

    protected function renderJSON($json)
    {
        Configure::write('debug', 0);
        $this->layout = null;
        $this->set('json', $json);
        $file = LAYOUTS . 'json' . $this->ext;
        return parent::render(null, null, $file);
    }

    protected function jsonStatus($success, $option = null)
    {
        $result = array();
        $result['isSuccess'] = $success;
        $result['ErrorCode'] = $success ? 0 : 1;
        if (is_int($option)) {
            $result['ErrorCode'] = $option;
        } elseif (is_array($option)) {
            $result = array_merge($result, $option);
        }
        return json_encode($result);
    }

    protected function renderJSONStatus($success, $option = null)
    {
        $this->renderJSON($this->jsonStatus($success, $option));
    }

    protected function params($name = '', $default = null)
    {
        if (!$name) {
            return array_merge($this->params['form'], $this->params['url']);
        }
        // POST
        if (isset($this->params['form'][$name])) return $this->params['form'][$name];
        // GET
        if (isset($this->params['url'][$name])) return $this->params['url'][$name];
        // Router
        if (isset($this->params[$name])) {
            $param = $this->params[$name];
            $param = str_replace(array('http://', 'https://'), array('http:/', 'https:/'), $param);
            $param = str_replace(array('http:/', 'https:/'), array('http://', 'https://'), $param);
            return $param;
        };
        return $default;
    }

    protected function isPOST()
    {
        return $_SERVER['REQUEST_METHOD'] === "POST";
    }

    protected function setMember()
    {
        $member_id = $this->Session->read('member_id');
        if (!is_numeric($member_id)) {
            $member_id = 0;
        }
        $this->member = new Member;
        $data = $this->member->findById($member_id);
        if (!$data) {
            $this->Flash->notice('You have been logged out.');
            $this->redirect('/login');
        }
        $this->member->set($data);
        $this->set('member', $this->member->data);
        $this->set('Member', $this->member);
        return true;
    }

    protected function verifySession()
    {
    
    }
}
