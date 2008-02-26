<?php
App::import('vendor', 'feed_utils');
class ApiFeedController extends AppController
{
    public $uses = array('Member', 'Feed', 'Subscription', 'Dir');

    public function discover()
    {
        $url = $this->params('url');
        $feeds = array();

        $feedlinks = FeedUtils::getFeedlinks($url);
        if (!$feedlinks) {
            $this->renderJSON(json_encode($feeds));
            return;
        }

        foreach ($feedlinks as $feedlink) {
            $feed = $this->Feed->findByFeedlink($feedlink);
            if ($feed) {
                $result = array(
                    'subscribers_count' => $feed['Feed']['subscribers_count'],
                    'feedlink' => $feed['Feed']['feedlink'],
                    'link' => $feed['Feed']['link'],
                    'title' => $feed['Feed']['title'],
                );
                $conditions = array();
                $conditions[] = es('Subscription.member_id = %s', $this->member->id);
                $conditions[] = es('Subscription.feed_id = %s', $feed['Feed']['id']);
                $sub = $this->Subscription->find($conditions);
                if ($sub) {
                    $result['subscribe_id'] = $sub['Subscription']['id'];
                }
                $feeds[] = $result;
            } else {
                $feeddata = FeedUtils::getFeed($feedlink);
                if (!$feeddata) continue;
                $feeds[] = array(
                    'subscribers_count' => 0,
                    'feedlink' => $feedlink,
                    'link' => $feeddata->get_permalink(),
                    'title' => $feeddata->get_title(),
                );
            }
        }

        $this->renderJSON(json_encode($feeds));
    }

    public function subscribe()
    {
        $feedlink = $this->params('feedlink');
        $options = array(
            'folder_id' => 0,
            'rate' => 0,
            'public' => $this->member->defaultPublic(),
        );
        $folder_id = $this->params('folder_id');
        if ($folder_id) {
            if ($this->member->folderExists($folder_id)) {
                $options['folder_id'] = $folder_id;
            } else {
                return $this->renderJSONStatus(false);
            }
        }
        $rate = $this->params('rate');
        if ($rate && $rate >= 0 && $rate <= 5) {
            $options['rate'] = (int)$rate;
        }
        $pub = $this->params('public');
        if ($pub) {
            $options['public'] = true;
        }

        $sub = $this->member->subscribeFeed($feedlink, $options);
        if (!$sub) {
            return $this->renderJSONStatus(false);
        }
        $this->renderJSONStatus(true, array('subscribe_id' => $sub['Subscription']['id']));
    }

    public function unsubscribe()
    {
        $sub = $this->getSubscription();
        if (!$sub) {
            return $this->renderJSONStatus(false);
        }
        $this->Subscription->set($sub);
        $this->Subscription->delete();
        $this->renderJSONStatus(true);
    }

    public function subscribed()
    {
        // FIXME: 
        $this->renderJSONStatus(false);
    }

    public function update()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    public function move()
    {
        $dest = $this->params('to');
        if (!$dest) {
            $folder_id = nulll;
        } else {
            $conditions = array();
            $conditions[] = es('Member.id = %s', $this->member->id);
            $conditions[] = es('Dir.name = %s', $dest);
            $folder = $this->Dir->find($conditions);
            if (!$folder) {
                $this->renderJSONStatus(false);
            }
            $folder_id = $folder['Dir']['id'];
        }

        $sub_id = $this->params('subscribe_id', 0);
        $ids = explode(',', $sub_id);
        foreach ($ids as $id) {
            $conditions = array();
            $conditions[] = es('Member.id = %s', $this->member->id);
            $conditions[] = es('Subscription.id = %s', $id);
            $sub = $this->Subscription->find($conditions);
            $sub['Subscription']['folder_id'] = $folder_id;
            $this->Subscription->set($sub);
            $this->Subscription->save();
        }
        $this->renderJSONStatus(true);
    }

    public function set_rate()
    {
        $sub = $this->getSubscription();
        if (!$sub) {
            return $this->renderJSONStatus(false);
        }
        $rate = $this->params('rate');
        $rate = (int)max(0, min($rate, 5));
        $sub['Subscription']['rate'] = $rate;
        $this->Subscription->set($sub);
        $this->Subscription->save();
        $this->renderJSONStatus(true);
    }

    public function set_notify()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    public function set_public()
    {
        $sub_id = $this->params('subscribe_id', 0);
        $is_public = $this->params('is_public', 0) != 0 ? true : false;

        $ids = explode(',', $sub_id);
        foreach ($ids as $id) {
            $conditions = array();
            $conditions[] = es('Member.id = %s', $this->member->id);
            $conditions[] = es('Subscription.id = %s', $id);
            $sub = $this->Subscription->find($conditions);
            $sub['Subscription']['public'] = $is_public;
            $this->Subscription->set($sub);
            $this->Subscription->save();
        }
        $this->renderJSONStatus(true);
    }

    public function add_tags()
    {
    }

    public function remove_tags()
    {
    }

    protected function getSubscription()
    {
        $id = $this->params('subscribe_id', 0);
        $conditions = array();
        $conditions[] = es('Member.id = %s', $this->member->id);
        $conditions[] = es('Subscription.id = %s', $id);
        return $this->Subscription->find($conditions);
    }
}
