<?php
App::import('vendor', 'cake_test_case_ext');
App::import('Model', 'Member');

class MemberTestCase extends CakeTestCaseExt
{
    public $fixtures = array(
        'crawl_status', 'favicon', 'feed',  'dir',
        'item', 'member', 'pin', 'subscription',
    );

    public function startTest($method)
    {
        $this->Member = new Member;
    }

    public function endTest($method)
    {
        unset($this->Member);
    }

    public function test_true()
    {
        $this->assertTrue(true);
    }

    public function test_read()
    {
        $r = $this->Member->read(null, 1);
        pr($r);
        $this->assertEqual($r['Member']['username'], 'quentin');
    }

    public function test_findByUsername()
    {
        $r = $this->Member->findByUsername('quentin');
        $this->assertEqual($r['Member']['username'], 'quentin');
        $this->assertEqual($r['Member']['email'], 'quentin@example.com');
    }

    public function test_serialize_config_dump()
    {
        $r = $this->Member->findByUsername('mala');
        $config = $r['Member']['config_dump'];
        $this->assertTrue(is_array($config));
        $this->assertEqual($config['autoreload'], 60);
        $this->assertEqual($config['scroll_type'], 'px');
    }

    public function test_encrypt()
    {
        $salt = '7e3041ebc2fc05a40c60028e2c4901a81035d3cd';
        $r = Member::encrypt('test', $salt);
        $this->assertEqual($r, '00742970dc9e6319f8019fd54864d3ea740f04b1');
    }

    public function test_createMember()
    {
        $before = $this->Member->findCount();

        $data = array(
            'username' => 'hoge',
            'email' => 'hoge@example.com',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
        );
        $r = $this->Member->save($data);

        $this->assertEqual($this->Member->findCount() - $before, 1);
    }

    public function test_authenticate()
    {
        $r = $this->Member->authenticate('quentin', 'test');
        $this->assertEqual($r['Member']['username'], 'quentin');
        $this->assertEqual($r['Member']['email'], 'quentin@example.com');

        // invalid username
        $r = $this->Member->authenticate('invaliduser', 'test');
        $this->assertFalse($r);

        // invalid password
        $r = $this->Member->authenticate('quentin', '');
        $this->assertFalse($r);
    }

    public function test_rememberMe()
    {
        $u = $this->Member->authenticate('quentin', 'test');
        $r = $this->Member->rememberMe($u);
        $this->assertTrue(is_array($r));
        $this->assertTrue(is_string($r['Member']['remember_token']));
        $this->assertNotNull($r['Member']['remember_token_expires_at']);
    }

    public function test_forgetMe()
    {
        $u = $this->Member->authenticate('quentin', 'test');
        $r = $this->Member->rememberMe($u);
        $this->assertNotNull($r['Member']['remember_token']);
        $r = $this->Member->forgetMe($r);
        $this->assertNull($r['Member']['remember_token']);
    }

    public function test_defaultPublic()
    {
        // public=0, default_public_status=0
        $u = $this->Member->authenticate('quentin', 'test');
        $this->assertFalse($this->Member->defaultPublic($u));

        // public=1, default_public_status=0
        $u['public'] = 1;
        $this->assertFalse($this->Member->defaultPublic($u));

        // public=1, default_public_status=1
        $u = $this->Member->authenticate('mala', 'test');
        $this->assertTrue($this->Member->defaultPublic($u));

        // public=0, default_public_status=1
        $u['public'] = 0;
        $this->assertTrue($this->Member->defaultPublic($u));
    }

    public function test_countSubscriptions()
    {
        $u = $this->Member->authenticate('quentin', 'test');
        $r = $this->Member->countSubscriptions($u);
        $this->assertEqual($r, 2);
    }
}
