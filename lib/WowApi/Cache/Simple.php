<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Simple extends Cache
{
    protected $options = array();

    protected $cache;

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function write($key, $data) {
        $this->cache[$key] = $data;
    }

    public function read($key) {
        return $this->cache[$key];
    }
}
