<?php
class MemberFixture extends CakeTestFixture
{
    public $name = 'Member';
    public $import = array('table' => 'members', 'connection' => 'default');

    public function __construct(&$db)
    {
        parent::__construct($db);

        $config_dump = <<< EOT
---
use_autoreload: "0"
reverse_mode: "0"
autoreload: "60"
prefetch_num: "2"
limit_subs: "100"
use_pinsaver: "1"
wait: "200"
scroll_px: "100"
touch_when: onload
max_view: "200"
scroll_type: px
use_scroll_hilight: "0"
use_wait: "0"
max_pin: "5"
use_limit_subs: "0"
ApiKey: BAh7CToMY3NyZl9pZCIlMTRmZWMwNTgzNmE0NmZmYjg5NDIxNDlhOTFjZjY1%0AYjQ6C21lbWJlcmkGOg5yZXR1cm5fdG8wIgpmbGFzaElDOidBY3Rpb25Db250%0Acm9sbGVyOjpGbGFzaDo6Rmxhc2hIYXNoewAGOgpAdXNlZHsA--79720c7867f3e5b1ababf83097803a8fc8ccc08f
items_per_page: "20"
default_public_status: "1"
use_prefetch_hack: "0"
current_font: "14"
EOT;

        $this->records = array(
            array(
                'id' => 1,
                'username' => 'quentin',
                'email' => 'quentin@example.com',
                'salt' => '7e3041ebc2fc05a40c60028e2c4901a81035d3cd',
                'crypted_password' => '00742970dc9e6319f8019fd54864d3ea740f04b1', // password=test
                'created_on' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ),
            array(
                'id' => 2,
                'username' => 'aaron',
                'email' => 'aaron@example.com',
                'salt' => '7e3041ebc2fc05a40c60028e2c4901a81035d3cd',
                'crypted_password' => '00742970dc9e6319f8019fd54864d3ea740f04b1', // password=test
                'created_on' => date('Y-m-d H:i:s', strtotime('-1 days')),
            ),
            array(
                'id' => 3,
                'username' => 'mala',
                'email' => 'mala@example.com',
                'salt' => '7e3041ebc2fc05a40c60028e2c4901a81035d3cd',
                'crypted_password' => '00742970dc9e6319f8019fd54864d3ea740f04b1', // password=test
                'config_dump' => $config_dump,
                'public' => 1,
                'created_on' => date('Y-m-d H:i:s', strtotime('-1 days')),
            ),
        );
    }
}
