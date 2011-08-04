<?php

use WowApi\Client;

class AuctionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \WowApi\Api\Auction
     */
    protected $api;

    protected function setUp()
    {
        $this->api = Shared::Client()->getAuctionApi();
    }

    protected function tearDown()
    {

    }

    function testGetAuctionIndex()
    {
        $auctions = $this->api->getAuctionIndex('Dragonblight');
        $this->assertArrayHasKey('url', $auctions);
        $this->assertArrayHasKey('lastModified', $auctions);
    }

    /**
     * @expectedException        WowApi\Exception\NotFoundException
     * @expectedExceptionMessage Realm not found.
     */
    function testGetNonExistentCharacter()
    {
        $this->api->getAuctions('DoesntExist');
    }
}
?>
