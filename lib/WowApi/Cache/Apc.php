<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Apc extends Cache
{
    protected $options = array(
        'ttl' => 3600,
    );

    public function __construct($options = array())
    {
        if(!function_exists('apc_store')) {
            throw new Exception("The APC extension does not seem to be loaded.");
        }
        parent::__construct($options);
    }

    public function write($key, $data) {
        apc_store($key, $data, $this->getOption('ttl'));
    }

    public function read($key) {
        return apc_fetch($key);
    }
}
