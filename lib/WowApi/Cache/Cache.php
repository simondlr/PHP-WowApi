<?php
namespace WowApi\Cache;

abstract class Cache implements CacheInterface
{
    protected $options = array();

    public function __construct($options)
    {
        $this->setOptions($options);
    }

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

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    public function getOption($name)
    {
        if(array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }

        return false;
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }
}
