<?php

use WowApi\Client;

class ClientTest extends PHPUnit_Framework_TestCase {
    /**
     * @var \WowApi\Client
     */
    protected $object;

    protected function setUp() {
    }

    protected function tearDown() {
    }

    function testApis() {
        $this->assertInstanceOf('\WowApi\Api\Character', Shared::Client()->getCharacterApi());
        $this->assertInstanceOf('\WowApi\Api\Classes', Shared::Client()->getClassesApi());
        $this->assertInstanceOf('\WowApi\Api\Guild', Shared::Client()->getGuildApi());
        $this->assertInstanceOf('\WowApi\Api\GuildPerks', Shared::Client()->getGuildPerksApi());
        $this->assertInstanceOf('\WowApi\Api\GuildRewards', Shared::Client()->getGuildRewardsApi());
        $this->assertInstanceOf('\WowApi\Api\Items', Shared::Client()->getItemsApi());
        $this->assertInstanceOf('\WowApi\Api\Races', Shared::Client()->getRacesApi());
        $this->assertInstanceOf('\WowApi\Api\Realm', Shared::Client()->getRealmApi());
    }

    function testDefaults() {
        $this->assertEquals(array(
                'protocol' => 'http',
                'region' => 'us',
                'url' => ':protocol://:region.battle.net/api/wow/:path',
                'publicKey' => null,
                'privateKey' => null,
                'ttl' => 3600,
            ), Shared::Client()->options->all());
    }

    //TODO: Finish test when authorization is enabled
    function testAuthentication()
    {
        Shared::Client()->authenticate(PUBLIC_KEY, PRIVATE_KEY);
        Shared::Client()->api('realm/status');
    }
}

?>
