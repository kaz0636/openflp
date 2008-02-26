<?php
App::import('vendor', 'string_utils');
class Item extends AppModel
{
    public $belongsTo = array('Feed');

    static public function toArray($item)
    {
        $result = array();
        $result['created_on'] = strtotime($item['created_on']);
        $result['modified_on'] = strtotime($item['modified_on']);
        $result['id'] = $item['id'];
        if ($item['enclosure_type']) {
            $result['enclosure_type'] = $item['enclosure_type'];
        }
        if ($item['enclosure']) {
            $result['enclosure'] = $item['enclosure'];
        }
        $result['title'] = purify_html($item['title']);
        $result['author'] = purify_html($item['author']);
        $result['category'] = purify_html($item['category']);
        $result['body'] = scrub_html($item['body']);
        $result['link'] = $item['link'];
        return $result;
    }
}
