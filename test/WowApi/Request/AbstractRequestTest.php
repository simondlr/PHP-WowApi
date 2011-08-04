<?php

use WowApi\Request\AbstractRequest;

abstract class AbstractRequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @todo Implement testSend().
     */
    public function testSend()
    {
        $client  = Shared::Client();

        $response = $client->getRequest()->send('realm/status');
        $this->assertArrayHasKey('realms', $response);
    }

    /**
     * @expectedException        WowApi\Exception\NotFoundException
     * @expectedExceptionMessage Page not found.
     */
    public function testSendToNonExistantPath()
    {
        $client  = Shared::Client();

        $response = $client->getRequest()->send('does/not/exist');
        $this->assertEquals(404, $response['headers']['http_code']);
    }

    /**
     * @expectedException        WowApi\Exception\NotFoundException
     */
    public function testSendToNonExistantResource()
    {
        $client  = Shared::Client();

        $response = $client->getRequest()->send('character/blank/blank');
        $this->assertEquals(404, $response['headers']['http_code']);
    }

    abstract function getRequestAdaptor();
}
?>
