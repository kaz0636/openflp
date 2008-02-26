<?php
App::import('vendor', 'feed_utils');
class SubscribeController extends AppController
{
    public $uses = array('Feed');

    public function index()
    {
        if ($this->params('feedlink')) {
            return $this->setAction('confirm');
        }
    }

    public function confirm()
    {
        if ($this->isPOST()) {
            return $this->setAction('subscribe');
        }

        $feeds = array();
        $url = $this->params('feedlink');
        $feedlinks = FeedUtils::getFeedlinks($url);
        foreach ($feedlinks as $feedlink) {
            $feed = $this->Feed->findByFeedlink($feedlink);
            if ($feed) {
                $sub = $this->member->subscribed($feed['Feed']['id']);
                if ($sub) {
                    $feed['subscribe_id'] = $sub['Subscription']['id'];
                }
                $feeds[] = $feed;
                continue;
            }
            $feeddata = FeedUtils::getFeed($feedlink);
            if (!$feeddata) continue;
            $feeds[] = array(
                'Feed' => array(
                    'id' => 0,
                    'subscribers_count' => 0,
                    'feedlink' => $feedlink,
                    'link' => $feeddata->get_permalink(),
                    'title' => $feeddata->get_title(),
                ),
            );
        }
        if (empty($feeds)) {
            $this->Flash->notice('please check URL');
            $this->redirect('/subscribe/index');
        }
        $this->set('feeds', $feeds);
        $this->set('feedlink', $feedlink);
    }

    protected function subscribe()
    {
        $check_for_subscribe = $this->params('check_for_subscribe');
        if (!$check_for_subscribe) {
            $this->Flash->notice('please check for subscribe');
            $this->redirect('subscribe/confirm?feedlink='.urlencode($this->params('url')));
        }
        $options = array(
            'public' => $this->params('public'),
            'rate' => $this->params('rate'),
            'folder_id' => $this->params('folder_id'),
        );
        foreach ($check_for_subscribe as $feedlink) {
            $this->member->subscribeFeed($feedlink, $options);
        }
        $this->redirect('/reader');
    }
}
