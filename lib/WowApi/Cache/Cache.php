<?php
namespace WowApi\Cache;

abstract class Cache implements CacheInterface
{
    public function getCachedResponse($path, $parameters)
    {
        return $this->read("wowapi:cache" . $this->getHash($path, $parameters));
    }

    public function setCachedResponse($path, $parameters, $response)
    {
        $this->write("wowapi:cache" . $this->getHash($path, $parameters), $response);
    }

    protected function getHash($path, $parameters)
    {
        return md5($path . serialize($parameters));
    }
}
