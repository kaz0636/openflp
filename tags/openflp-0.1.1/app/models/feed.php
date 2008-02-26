<?php
class Feed extends AppModel
{
    public $hasOne = array('CrawlStatus', 'Favicon');
    public $hasMany = array('Item', 'Subscription');

    public function icon($data = null)
    {
        $this->set($data);
        if (!empty($this->data['Favicon'])) {
            return "/icon/{$this->data['Feed']['id']}";
        } else {
            return '/img/icon/default.png';
        }
    }

    public function updateSubscribersCount($data = null)
    {
        $this->set($data);
        $conditions = es('Subscription.feed_id = %s', $this->id);
        $n = $this->Subscription->findCount($conditions);
        CakeLog::write(LOG_INFO, "subscribers: {$n}");
        return $this->saveField('subscribers_count', $n);
    }

    public function createCrawlStatus()
    {
        if (!$this->id) {
            return false;
        }
        $data = array('feed_id' => $this->id);
        $this->CrawlStatus->set($data);
        return $this->CrawlStatus->save();
    }
}
