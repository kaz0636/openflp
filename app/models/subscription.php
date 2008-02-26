<?php
class Subscription extends AppModel
{
    public $belongsTo = array(
        'Member',
        'Feed',
        'Dir' => array('foreignKey' => 'folder_id'),
    );

    public function beforeSave()
    {
        if (empty($this->data['Subscription']['public'])) {
            $this->data['Subscription']['public'] = false;
        }
        return parent::beforeSave();
    }

    public function afterSave($created)
    {
        if ($created) {
            $this->data['Subscription']['id'] = $this->id;
            $this->Feed->id = $this->data['Subscription']['feed_id'];
            $this->Feed->updateSubscribersCount();
        }
        parent::afterSave($created);
    }

    public function afterDelete()
    {
        $this->Feed->id = $this->data['Subscription']['feed_id'];
        $this->Feed->updateSubscribersCount();
    }

    public function average($feed_id)
    {
        $sql = es('SELECT AVG(rate) AS avg_rate FROM subscriptions WHERE feed_id = %s AND rate > 0', $feed_id);
        $r = $this->query($sql);
        return !empty($r[0][0]['avg_rate']) ? (int)$r[0][0]['avg_rate'] : 0;
    }
}
