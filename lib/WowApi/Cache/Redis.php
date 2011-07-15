<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Memcache extends Cache
{
    /**
     * @var \Predis\Client
     */
    protected $redis;

    protected $options = array(
        'ttl' => 3600,
    );

    public function __construct(\Predis\Client $redis, $options = array())
    {
        $this->redis = $redis;
        parent::__construct($options);
    }

    public function write($key, $data) {
        $this->redis->setex($key, $this->getOption('ttl'), $data);
    }

    public function read($key) {
        return $this->redis->get($key);
    }
}
