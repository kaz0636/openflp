<?php
App::import('vendor', 'feed_utils');
class Member extends AppModel
{
    public $hasMany = array('Dir', 'Subscription', 'Pin');
    public $serialize = array('config_dump');
    public $validate = array(
        'username' => array(
            'unique' => array('rule' => array('validateUniqueUsername', 'hoge')),
            'minLength' => array('rule' => array('minLength', 3)),
            'maxLength' => array('rule' => array('maxLength', 40)),
        ),
        'password' => array(
            'confirm' => array('rule' => array('validatePassword')),
            'minLength' => array('rule' => array('minLength', 4)),
            'maxLength' => array('rule' => array('maxLength', 40)),
        ),
    );

    public function validateUniqueUsername($fields)
    {
        $this->User->recursive = -1;
        $r = $this->findByUsername($fields['username']);
        return $r ? false : true;
    }

    public function validatePassword($fields)
    {
        return $this->data['Member']['password'] === $this->data['Member']['password_confirmation'];
    }

    public function beforeSave()
    {
        // encrypt password
        if (!empty($this->data['Member']['password'])) {
            if (!$this->id) {
                $time = time();
                $this->data['Member']['salt'] = sha1("--{$time}--{$this->data['Member']['username']}");
            }
            $this->data['Member']['crypted_password'] = Member::encrypt(
                $this->data['Member']['password'], $this->data['Member']['salt']
            );
        }
        return parent::beforeSave();
    }

    static public function encrypt($password, $salt)
    {
        return sha1("--{$salt}--{$password}--");
    }

    static public function isAuthenticated($crypted_password, $password, $salt)
    {
        return $crypted_password === Member::encrypt($password, $salt);
    }

    public function authenticate($username, $password)
    {
        $r = $this->findByUsername($username);
        if (!$r) return false;
        $is_auth = $this->isAuthenticated(
            $r['Member']['crypted_password'],
            $password,
            $r['Member']['salt']
        );
        return $is_auth ? $r : false;
    }

    public function rememberToken()
    {
        // FIXME
    }

    public function rememberMe($data = null)
    {
        $this->set($data);
        $t = new DateTime;
        $t->modify('+2 weeks');
        $t->setTimeZone(new DateTimeZone('UTC'));
        $token_expires_at = $t->format('D M d H:i:s e Y');
        $key = "{$this->data['Member']['username']}--{$token_expires_at}";
        $this->data['Member']['remember_token_expires_at'] = $t->format('Y-m-d H:i:s');
        $this->data['Member']['remember_token'] = Member::encrypt($key, $this->data['Member']['salt']);
        return $this->save(false);
    }

    public function forgetMe($data = null)
    {
        $this->set($data);
        $this->data['Member']['remember_token_expires_at'] = null;
        $this->data['Member']['remember_token'] = null;
        return $this->save(false);
    }

    public function defaultPublic($data = null)
    {
        $this->set($data);
        if (!$this->data['Member']['public']) {
            return false;
        }
        if (empty($this->data['Member']['config_dump']['default_public_status'])) {
            return false;
        }
        return $this->data['Member']['config_dump']['default_public_status'];
    }

    public function subscribeFeed($feedlink, $options = array())
    {
        if ($this->countSubscriptions() >= SUBSCRUBE_LIMIT) {
            $msg = sprintf(
                'SUBSCRIBE LIMIT: %s(%s) %s',
                $this->data['Member']['username'], $this->id, $feedlink
            );
            CakeLog::write(LOG_WARNING, $msg);
            return false;
        }

        $Feed = new Feed;
        $feed = $Feed->findByFeedlink($feedlink);

        if ($feed) {

            // subscribed..
            $Feed->set($feed);

        } elseif (isset($options['quick'])) {
            $data = array(
                'feedlink' => $feedlink,
                'link' => $feedlink,
                'title' => $options['title'],
                'description' => '',
            );
            $Feed->set($data);
            $Feed->save();
            $Feed->createCrawlStatus();
        } else {
            $feeddata = FeedUtils::getFeed($feedlink);
            if (!$feeddata) {
                return false;
            }
            $data = array(
                'subscribers_count' => 0,
                'feedlink' => $feedlink,
                'link' => $feeddata->get_permalink() ? $feeddata->get_permalink() : '',
                'title' => $feeddata->get_title() ? $feeddata->get_title() : '',
            );
            $Feed->set($data);
            $Feed->save();
            $Feed->createCrawlStatus();
        }

        unset($options['quick']);
        unset($options['title']);

        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        $conditions[] = es('Subscription.feed_id = %s', $Feed->id);
        $sub = $this->Subscription->find($conditions);
        if ($sub) {
            return $sub;
        }

        $data = array(
            'member_id' => $this->id,
            'feed_id' => $Feed->id,
            'has_unread' => true,
        );
        $data = array_merge($data, $options);
        $this->Subscription->create($data);
        return $this->Subscription->save();
    }

    public function subscribed($feed_id)
    {
        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        $conditions[] = es('Subscription.feed_id = %s', $feed_id);
        $this->Subscription->recursive = -1;
        return $this->Subscription->find($conditions);
    }

    public function checkSubscribed($feedlink)
    {
        $Feed = new Feed;
        $Feed->recursive = -1;
        $feed = $Feed->findByFeedlink($feedlink);
        return $this->subscribed($feed['Feed']['id']);
    }

    public function totalSubscribeCount()
    {
        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        return $this->Subscription->findCount($conditions);
    }

    public function publicSubscribeCount()
    {
        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        $conditions[] = es('Subscription.public = true');
        return $this->Subscription->findCount($conditions);
    }

    public function publicSubs()
    {
        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        $conditions[] = es('Subscription.public = true');
        return $this->Subscription->findAll($conditions);
    }

    public function recentSubs($num)
    {
        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        $order = 'Subscription.created_on DESC';
        $limit = $num;
        return $this->Subscription->findAll($conditions, null, $order, $limit);
    }

    public function countSubscriptions($data = null)
    {
        $this->set($data);
        $conditions = array();
        $conditions[] = es('Subscription.member_id = %s', $this->id);
        return $this->Subscription->findCount($conditions);
    }

    public function folderExists($folder_id)
    {
        foreach ($this->data['Dir'] as $folder) {
            if ($folder['id'] === $folder_id) {
                return true;
            }
        }
        return false;
    }
}
