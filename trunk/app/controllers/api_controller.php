<?php
class ApiController extends AppController
{
    public $uses = array('Member', 'Subscription', 'Feed', 'Item');
    protected $sub = null;

    public function all()
    {
        $this->findSub();

        $limit = $this->params('limit', MAX_UNREAD_COUNT);
        $limit = $limit <= 0 ? MAX_UNREAD_COUNT : min($limit, MAX_UNREAD_COUNT);
        $limit = (int)$limit;
        $offset = (int)($this->params('offset', 0));

        $conditions = array();
        $conditions[] = es('Item.feed_id = %s', $this->sub['Subscription']['feed_id']);
        $fields = null;
        $order = es('Item.created_on DESC, Item.id DESC');
        $page = $offset / $limit + 1;
        $r = $this->Item->findAll($conditions, $fields, $order, $limit, $page, -1);
        $items = array();
        foreach ($r as $v) {
            $items[] = Item::toArray($v['Item']);
        }

        $result = array(
            'subscribe_id' => $this->sub['Subscription']['id'],
            'channel' => $this->sub['Feed'],
            'items' => $items,
        );
        if ($this->sub['Subscription']['ignore_notify']) {
            $result['ignore_notify'] = 1;
        }

        $this->renderJSON(json_encode($result));
    }

    public function unread()
    {
        $this->findSub();

        $conditions = array();
        if (!empty($this->sub['Subscription']['viewed_on'])) {
            $conditions[] = es('Item.stored_on >= %s', $this->sub['Subscription']['viewed_on']);
        }
        $conditions[] = es('Item.feed_id = %s', $this->sub['Subscription']['feed_id']);
        $fields = null;
        $order = es('Item.created_on DESC, Item.id DESC');
        $limit = MAX_UNREAD_COUNT;
        $r = $this->Item->findAll($conditions, $fields, $order, $limit);
        $items = array();
        foreach ($r as $v) {
            $items[] = Item::toArray($v['Item']);
        }

        $result = array(
            'subscribe_id' => $this->sub['Subscription']['id'],
            'channel' => $this->sub['Feed'],
            'items' => $items,
        );
        if (count($items) > 0) {
            $result['last_stored_on'] = $r[count($items)-1]['Item']['stored_on'];
        }
        if ($this->sub['Subscription']['ignore_notify']) {
            $result['ignore_notify'] = 1;
        }

        $this->renderJSON(json_encode($result));
    }

    public function touch_all()
    {
        $ids = explode(',', $this->params('subscribe_id'));
        foreach ($ids as $id) {
            $conditions = array();
            $conditions[] = es('Subscription.member_id = %s', $this->member->id);
            $conditions[] = es('Subscription.id = %s', $id);
            $sub = $this->Subscription->find($conditions);
            if ($sub) {
                $sub['Subscription']['has_unread'] = false;
                $sub['Subscription']['viewed_on'] = date('Y-m-d H:i:s');
                $this->Subscription->set($sub);
                $this->Subscription->save();
            }
        }

        $this->renderJSONStatus(true);
    }

    public function touch()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    public function item_count()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    public function unread_count()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    public function subs()
    {
        $limit = $this->params('limit', 0);
        $from_id = $this->params('from_id', 0);
        $unread = $this->params('unread', 0);

        $conditions = array(); 
        $conditions[] = es('Subscription.member_id = %s', $this->member->id);
        if ($unread) {
            $conditions[] = es('Subscription.has_unread = true');
        }
        $fields = null;
        $order = es('Subscription.id');
        $r = $this->Subscription->findAll($conditions, $fields, $order);

        $items = array();

        foreach ($r as $sub) {
            $conditions = array();
            $conditions[] = es('Item.feed_id = %s', $sub['Subscription']['feed_id']);
            if (!empty($sub['Subscription']['viewed_on'])) {
                $conditions[] = es('Item.stored_on >= %s', $sub['Subscription']['viewed_on']);
            }
            $unread_count = $this->Item->findCount($conditions);
            if ($unread && $unread_count == 0) continue;
            if ($sub['Subscription']['id'] < $from_id) continue;
            $item = array(
                'subscribe_id' => $sub['Subscription']['id'],
                'unread_count' => min($unread_count, MAX_UNREAD_COUNT),
                'folder' => empty($sub['Dir']['name']) ? '' : h($sub['Dir']['name']),
                'tags' => array(),
                'rate' => $sub['Subscription']['rate'],
                'public' => $sub['Subscription']['public'] ? 1 : 0,
                'link' => h($sub['Feed']['link']),
                'feedlink' => h($sub['Feed']['feedlink']),
                'title' => h($sub['Feed']['title']),
                'icon' => $this->Feed->icon($sub['Feed']),
                'modified_on' => strtotime($sub['Feed']['modified_on']),
                'subscribers_count' => $sub['Feed']['subscribers_count'],
            );
            if ($sub['Subscription']['ignore_notify']) {
                $item['ignore_notify'] = 1;
            }
            $items[] = $item;
            if ($limit > 0 && count($items) >= $limit) {
                break;
            }
        }

        $this->renderJSON(json_encode($items));
    }

    public function lite_subs()
    {
        $items = array();

        $conditions = array(); 
        $conditions[] = es('Subscription.member_id = %s', $this->member->id);
        $r = $this->Subscription->findAll($conditions);

        foreach ($r as $sub) {
            $item = array(
                'subscribe_id' => $sub['Subscription']['id'],
                'folder' => empty($sub['Dir']['name']) ? '' : h($sub['Dir']['name']),
                'rate' => $sub['Subscription']['rate'],
                'public' => $sub['Subscription']['public'] ? 1 : 0,
                'link' => h($sub['Feed']['link']),
                'feedlink' => h($sub['Feed']['feedlink']),
                'title' => h($sub['Feed']['title']),
                'icon' => $this->Feed->icon($sub['Feed']),
                'modified_on' => strtotime($sub['Feed']['modified_on']),
                'subscribers_count' => $sub['Feed']['subscribers_count'],
            );
            if ($sub['Subscription']['ignore_notify']) {
                $item['ignore_notify'] = 1;
            }
            $items[] = $item;
        }
        $this->renderJSON(json_encode($items));
    }

    public function error_subs()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    public function folders()
    {
        $names = array();
        $name2id = array();
        $folders = !empty($this->member->data['Dir']) ? $this->member->data['Dir'] : array();
        foreach ($folders as $folder) {
            $names[] = $folder['name'];
            $name2id[$folder['name']] = $folder['id'];
        }
        $folders = array(
            'names' => $names,
            'name2id' => $name2id,
        );
        $this->renderJSON(json_encode($folders));
    }

    public function crawl()
    {
        // FIXME: hidden api?
        $this->renderJSONStatus(false);
    }

    protected function findSub()
    {
        $id = $this->params('subscribe_id', 0);
        if (!$id) {
            $id = $this->params('id', 0);
        }
        $conditions = array();
        $conditions[] = es('Member.id = %s', $this->member->id);
        $conditions[] = es('Subscription.id = %s', $id);
        $this->sub = $this->Subscription->find($conditions);
        return $this->sub ? true : false;
    }
}
