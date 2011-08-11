<?php
namespace WowApi\Cache;

use WowApi\Exception\Exception;

class Memcache extends AbstractCache
{
    /**
     * @var \Memcache
     */
    protected $memcache;

    public function __construct($options = array())
    {
        parent::__construct($options);

        //Load memcache
        if (!extension_loaded('memcache')) {
            throw new Exception("The Memcache extension does not seem to be loaded.");
        }

        $this->memcache = new \Memcache();
        $this->loadServers($this->options->get('servers', array(
            array('host' => 'localhost'),
        )));
    }

    protected function loadServers($servers)
    {
        foreach($servers as $server) {
            if(!isset($server['host'])) {
                throw new \InvalidArgumentException("Each server must have a valid host parameter");
            }
            $server = array_merge(array(
                'host' => 'localhost',
                'port' => 11211,
                'persistent' => null,
                'weight' => 1,
                'timeout' => null,
            ), $server);

            $this->memcache->addserver($server['host'], $server['port'], $server['persistent'], $server['weight'], $server['timeout']);
        }
    }

    public function write($key, $data) {
        $this->memcache->set($key, $data, MEMCACHE_COMPRESSED, $this->options->get('ttl', 3600));
    }

    public function read($key) {
        return $this->memcache->get($key);
    }
}
