<?php

use WowApi\Cache\Simple;

class SimpleTest extends AbstractCacheTest
{
    function getCacheAdaptor()
    {
        return new Simple();
    }
}
?>
