<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Memcache extends Cache
{
    /**
     * @var \Memcache
     */
    protected $memcache;

    protected $options = array(
        'servers' => array(
            array('host' => '127.0.0.1'),
        ),
        'ttl' => 3600,
    );

    public function __construct($options = array())
    {
        //Load memcache
        if (!extension_loaded('memcache')) {
            throw new Exception("The Memcache extension does not seem to be loaded.");
        }
        $this->memcache = new \Memcache();

        //Load servers
        foreach($this->getOption('servers') as $server) {
            if(!isset($server['host'])) {
                throw new \InvalidArgumentException("Each server must have a valid host parameters");
            }
            $server = array_merge(array(
                'port' => null,
                'persistent' => null,
                    'weight' => null,
                'timeout' => null,
            ), $server);
            $this->memcache->addserver($server['host'], $server['port'], $server['persistent'], $server['weight'], $server['timeout']);
        }

        parent::__construct($options);
    }

    public function write($key, $data) {
        $this->memcache->set($key, $data, MEMCACHE_COMPRESSED, $this->getOption('ttl'));
    }

    public function read($key) {
        return $this->memcache->get($key);
    }
}
