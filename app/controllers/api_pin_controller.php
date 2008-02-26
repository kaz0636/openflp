<?php
class ApiPinController extends AppController
{
    public $uses = array('Pin');

    public function all()
    {
        $pins = array();
        $r = !empty($this->member->data['Pin']) ? $this->member->data['Pin'] : array();
        foreach ($r as $v) {
            $pins[] = Pin::toArray($v);
        }
        $this->renderJSON(json_encode($pins));
    }

    public function add()
    {
        $link = $this->params('link');
        $title = $this->params('title');
        
        $data = array(
            'member_id' => $this->member->id,
            'link' => $link,
            'title' => $title,
        );
        $this->Pin->set($data);
        $this->Pin->save();

        $conditions = array();
        $conditions[] = es('Pin.member_id = %s', $this->member->id);
        $n = $this->Pin->findCount($conditions);
        if ($n > SAVE_PIN_LIMIT) {
            $pin = $this->Pin->find($conditions, null, 'Pin.created_on ASC');
            $this->Pin->del($pin['Pin']['id']);
        }
        $this->renderJSONStatus(true);
    }

    public function remove()
    {
        $link = $this->params('link');

        $conditions = array();
        $conditions[] = es('Pin.member_id = %s', $this->member->id);
        $conditions[] = es('Pin.link = %s', $link);
        $pin = $this->Pin->find($conditions);
        if ($pin) {
            $this->Pin->del($pin['Pin']['id']);
        }
        
        $this->renderJSONStatus(true);
    }

    public function clear()
    {
        $conditions = array();
        $conditions[] = es('Pin.member_id = %s', $this->member->id);
        $this->Pin->deleteAll($conditions);
        $this->renderJSONStatus(true);
    }
}
