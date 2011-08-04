<?php

use WowApi\Cache\Null;

class NullTest extends AbstractCacheTest
{
    public function testSetCachedResponse()
    {
        $cache = $this->getCacheAdaptor();
        $data = array('status' => 'nok', 'reason' => 'Test');

        $cache->setCachedResponse('/test/cache', array(), json_encode($data));
        $cachedData = $cache->getCachedResponse('/test/cache', array());

        $this->assertEquals(false, $cachedData);
    }

    function getCacheAdaptor()
    {
        return new Null();
    }
}
?>
