<?php
class Dir extends AppModel
{
    public $useTable = 'folders';
    public $belongsTo = array('Member');
    public $hasMany = array('Subscription'); // :dependent => :nullify

    public function afterDelete()
    {
        $conditions = array();
        $conditions[] = es('Subscription.folder_id = %s', $this->id);
        $this->Subscription->updateAll(array('folder_id' => 0), $conditions);
    }
}
