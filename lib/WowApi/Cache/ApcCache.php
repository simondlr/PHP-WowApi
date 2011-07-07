<?php
namespace WowApi\Cache;

class ApcCache extends Cache
{
    public function write($key, $data) {
        apc_store($key, $data);
    }

    public function read($key) {
        return apc_fetch($key);
    }
}
