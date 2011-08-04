<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Redis extends AbstractCache
{
    /**
     * @var \Predis\Client
     */
    protected $redis;

    public function __construct(\Predis\Client $redis, $options = array())
    {
        parent::__construct($options);

        $this->redis = $redis;
    }

    public function write($key, $data) {
        $this->redis->setex($key, $this->options->get('ttl', 3600), $data);
    }

    public function read($key) {
        return $this->redis->get($key);
    }
}
