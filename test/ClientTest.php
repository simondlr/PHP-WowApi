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

    //TODO: Finish test when authorization is enabled
    function testAuthentication()
    {
        Shared::Client()->authenticate(PUBLIC_KEY, PRIVATE_KEY);
        Shared::Client()->api('realm/status');
    }

    function testRegionsAndLocales()
    {
        Shared::Client()->setRegion('us');
        $this->assertEquals(Shared::Client()->options->get('region'), 'us');
        $this->assertEquals(Shared::Client()->options->get('locale'), 'en_US');

        Shared::Client()->setRegion('us', 'es_MX');
        $this->assertEquals(Shared::Client()->options->get('region'), 'us');
        $this->assertEquals(Shared::Client()->options->get('locale'), 'es_MX');

        Shared::Client()->setRegion('eu', 'en_GB');
        $this->assertEquals(Shared::Client()->options->get('region'), 'eu');
        $this->assertEquals(Shared::Client()->options->get('locale'), 'en_GB');

        Shared::Client()->setRegion('cn');
        $this->assertEquals(Shared::Client()->options->get('region'), 'cn');
        $this->assertEquals(Shared::Client()->options->get('locale'), 'zh_CN');
    }
}

?>
