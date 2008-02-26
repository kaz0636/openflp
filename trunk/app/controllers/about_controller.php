<?php
class AboutController extends AppController
{
    public $uses = array('Feed', 'Subscription');

    public function index()
    {
        $feedlink = $this->params('feedlink');
        if (!$feedlink) {
            $this->renderJSON(json_encode(null));
            return;
        }
        $this->Feed->recursive = -1;
        $feed = $this->Feed->find(array('feedlink' => $feedlink));
        $this->Feed->set($feed);
        if (!$feed) {
            $this->renderJSON(json_encode(null));
            return;
        }
        $this->set('is_feedlink', true);
        $this->set('feed', $feed);
        $this->set('Feed', $this->Feed);
        $this->set('Subscription', $this->Subscription);
    }
}
