<?php

use WowApi\Client;

class RealmTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \WowApi\Api\Realm
     */
    protected $api;

    protected function setUp()
    {
        $this->api = Shared::Client()->getRealmApi();
    }

    protected function tearDown()
    {
    }

    function testGetRealms()
    {
        $realms = $this->api->getRealms();
        //Choose random realm to test
        $realm = $realms[rand(0, count($realms)-1)];
        $this->assertArrayHasKey('type', $realm);
        $this->assertArrayHasKey('queue', $realm);
        $this->assertArrayHasKey('status', $realm);
        $this->assertArrayHasKey('population', $realm);
        $this->assertArrayHasKey('name', $realm);
        $this->assertArrayHasKey('slug', $realm);
    }

    function testGetRealm()
    {
        $realm = $this->api->getRealm('Dragonblight');
        $this->assertArrayHasKey('type', $realm);
        $this->assertArrayHasKey('queue', $realm);
        $this->assertArrayHasKey('status', $realm);
        $this->assertArrayHasKey('population', $realm);
        $this->assertArrayHasKey('name', $realm);
        $this->assertArrayHasKey('slug', $realm);
    }

    function testGetMultipleRealms()
    {
        $realms = $this->api->getRealms(array('Dragonblight', 'Boulderfist'));
        $realm = $realms[1];
        $this->assertArrayHasKey('type', $realm);
        $this->assertArrayHasKey('queue', $realm);
        $this->assertArrayHasKey('status', $realm);
        $this->assertArrayHasKey('population', $realm);
        $this->assertArrayHasKey('name', $realm);
        $this->assertArrayHasKey('slug', $realm);
    }

//    //API returns all realms if a non existant realm is requested
//    function testGetNonExistantRealm()
//    {
//        $realm = $this->api->getRealm('DoesntExist');
//        $this->assertArrayHasKey('type', $realm);
//        $this->assertArrayHasKey('queue', $realm);
//        $this->assertArrayHasKey('status', $realm);
//        $this->assertArrayHasKey('population', $realm);
//        $this->assertArrayHasKey('name', $realm);
//        $this->assertArrayHasKey('slug', $realm);
//    }
}
?>
