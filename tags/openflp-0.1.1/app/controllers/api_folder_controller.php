<?php
class ApiFolderController extends AppController
{
    public $uses = array('Dir');

    const ERR_ALREADY_EXISTS = 10;

    public function create()
    {
        $name = $this->params('name');
        if (!$name) {
            return $this->renderJSONStatus(false);
        }

        $conditions = array();
        $conditions[] = es('Member.id = %s', $this->member->id);
        $conditions[] = es('Dir.name = %s', $name);
        $folder = $this->Dir->find($conditions);
        if ($folder) {
            return $this->renderJSONStatus(false, self::ERR_ALREADY_EXISTS);
        }
        $data = array(
            'member_id' => $this->member->id,
            'name' => $name,  
        );
        $this->Dir->set($data);
        $this->Dir->save();
        $this->renderJSONStatus(true);
    }

    public function delete()
    {
        $folder = $this->getFolder();
        if (!$folder) {
            return $this->renderJSONStatus(false);
        }
        $this->Dir->set($folder);
        $this->Dir->delete();
        $this->renderJSONStatus(true);
    }

    public function update()
    {
        $folder = $this->getFolder();
        if (!$folder) {
            return $this->renderJSONStatus(false);
        }
        $name = $this->params('name');
        if (!$name) {
            return $this->renderJSONStatus(false);
        }
        $folder['Dir']['name'] = $name;
        $this->Dir->set($folder);
        $this->Dir->save();
        $this->renderJSONStatus(true);
    }

    protected function getFolder()
    {
        $id = $this->params('folder_id', 0);
        $conditions = array();
        $conditions[] = es('Member.id = %s', $this->member->id);
        $conditions[] = es('Dir.id = %s', $id);
        return $this->Dir->find($conditions);
    }
}
