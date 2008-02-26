<?php
App::import('vendor', 'string_utils');
class Pin extends AppModel
{
    public $belongsTo = array('Member');

    static public function toArray($pin)
    {
        $result = array();
        $result['link'] = purify_url($pin['link']);
        $result['title'] = purify_html($pin['title']);
        $result['created_on'] = strtotime($pin['created_on']);
        return $result;
    }
}
