<?php
namespace WowApi\Cache;

use WowApi\ParameterBag;

abstract class AbstractCache implements CacheInterface
{
    public $options = array();

    public function __construct($options)
    {
        $this->options = new ParameterBag($options);
    }

    public function getCachedResponse($url, $parameters)
    {
        return $this->read("wowapi:cache" . $this->getHash($url, $parameters));
    }

    public function setCachedResponse($url, $parameters, $response)
    {
        $this->write("wowapi:cache" . $this->getHash($url, $parameters), $response);
    }

    protected function getHash($url, $parameters)
    {
        return md5($url . json_encode($parameters));
    }
}
