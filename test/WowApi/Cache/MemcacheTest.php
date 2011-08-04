<?php

use WowApi\Cache\Memcache;

class MemcacheTest extends AbstractCacheTest
{
    protected function setUp()
    {
        parent::setUp();

        if (!extension_loaded('memcache')) {
            $this->markTestSkipped('Memcache is not installed');
        }
    }

    function getCacheAdaptor()
    {
        return new Memcache();
    }
}
?>
