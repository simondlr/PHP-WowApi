<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Null extends AbstractCache
{
    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function write($key, $data) {
        return;
    }

    public function read($key) {
        return false;
    }
}
