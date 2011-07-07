<?php
namespace WowApi\Cache;

abstract class Cache implements CacheInterface
{
    public function getCachedResponse($path, $parameters)
    {
        $return = array();
        $return['last-modified'] = $this->read("wowapi:last-modified" . $this->getHash($path, $parameters));
        $return['response']      = $this->read("wowapi:response" . $this->getHash($path, $parameters));
        return $return;
    }

    public function setCachedResponse($path, $parameters, $response, $date)
    {
        $this->write("wowapi:last-modified" . $this->getHash($path, $parameters), $date);
        $this->write("wowapi:response" . $this->getHash($path, $parameters), $response);
    }

    protected function getHash($path, $parameters)
    {
        return md5($path . serialize($parameters));
    }
}
