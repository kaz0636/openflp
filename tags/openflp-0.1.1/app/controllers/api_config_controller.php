<?php
class ApiConfigController extends AppController
{
    public $uses = null;

    public function get()
    {
        $config = array();
        if (!empty($this->member->data['Member']['config_dump'])) {
            $config = $this->member->data['Member']['config_dump'];
        }
        $this->renderJSON(json_encode($config));
    }

    public function put()
    {
        $member_public = $this->params('member_public', 0);
        $member_public = !empty($member_public);

        $config = array();
        if (!empty($this->member->data['Member']['config_dump'])) {
            $config = $this->member->data['Member']['config_dump'];
        }
        foreach ($this->params() as $k => $v) {
            if (in_array($k, array('url', 'member_public'))) continue;
            $config[$k] = $v;
        }
        $this->member->data['Member']['config_dump'] = $config;
        $this->member->save();
        $this->renderJSON(json_encode($config));
    }
}
