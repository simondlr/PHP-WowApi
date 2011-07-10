<?php
namespace WowApi;

use WowApi\Cache\CacheInterface;
use WowApi\Exception\Exception;
use WowApi\Request\Curl;
use WowApi\Request\RequestInterface;
use WowApi\Api\ApiInterface;
use WowApi\Api\Character;
use WowApi\Api\Classes;
use WowApi\Api\Items;
use WowApi\Api\Guild;
use WowApi\Api\GuildPerks;
use WowApi\Api\GuildRewards;
use WowApi\Api\Races;
use WowApi\Api\Realm;

if (!function_exists('json_decode')) {
    throw new Exception('This API client needs the JSON PHP extension.');
}

class Client
{
    /**
     * @var null|\WowApi\Request\RequestInterface Request class
     */
    protected $request = null;

    /**
     * @var null|\WowApi\Cache\CacheInterface Cache engine
     */
    protected $cache = null;

    /**
     * @var array Array containing options
     */
    protected $options = array(
        'protocol' => 'http',
        'region' => 'us',
        'url' => ':protocol://:region.battle.net/api/wow/:path',
        'publicKey' => null,
        'privateKey' => null,
    );

    /**
     * @var array Array containing the instances of the API classes
     */
    protected $apis;

    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    protected function getSupportedRegions() {
        return array('us', 'eu', 'kr', 'tw', 'cn');
    }

    /**
     * Make an API call
     * @param $path
     * @param array $parameters
     * @param string $httpMethod
     * @param array $options
     * @return void
     */
    public function api($path, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        $this->getRequest()->send($path, $parameters, $httpMethod, $options);
    }

    /**
     * Authenticate the application
     * @param $publicKey
     * @param $privateKey
     * @return void
     */
    public function authenticate($publicKey, $privateKey)
    {
        $this->setOption('publicKey', $publicKey);
        $this->setOption('privateKey', $privateKey);
    }

    /**
     * Set the region
     * @throws \InvalidArgumentException
     * @param $region
     * @return void
     */
    public function setRegion($region)
    {
        $region = strtolower($region);

        if(in_array($region, $this->getSupportedRegions())) {
            $this->options['region'] = $region;
        } else {
            throw new \InvalidArgumentException(sprintf('The region %s is not supported.', $region));
        }
    }

    /**
     * @throws Exception\Exception
     * @return \WowApi\Request\RequestInterface
     */
    public function getRequest() {
        if($this->request === null) {
            throw new Exception("A request class must be specified.");
        }

        return $this->request;
    }

    /**
     * @param \WowApi\Request\RequestInterface $request
     * @return void
     */
    public function setRequest(\WowApi\Request\RequestInterface $request) {
        $this->request = $request;
    }

    /**
     * @param $name
     * @return \WowApi\Api\ApiInterface
     */
    public function getApi($name)
    {
        return $this->apis[$name];
    }

    /**
     * @param $name
     * @param \WowApi\Api\ApiInterface $instance
     * @return void
     */
    public function setApi($name, ApiInterface $instance)
    {
        $this->apis[$name] = $instance;
    }

    /**
     * Sets the cache engine
     * @param Cache\CacheInterface $cache
     * @return void
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Gets the cache engine
     * @return false|Cache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Get a single option
     * @param $name
     * @return mixed
     */
    public function getOption($name) {
        return $this->options[$name];
    }

    /**
     * Set a single option
     * @param $name
     * @param $value
     * @return void
     */
    public function setOption($name, $value) {
        $this->options[$name] = $value;
    }

    /**
     * Get an array containing all the options
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * Stores an array of options
     * @param $options
     * @return void
     */
    public function setOptions($options) {
        $this->options = array_merge($options, $this->options);
    }

    /** API's **/

    /**
     * Returns the character API
     * @return \WowApi\Api\Character
     */
    public function getCharacterApi()
    {
        if (!isset($this->apis['character'])) {
            $this->setApi('character', new Character($this->getRequest()));
        }

        return $this->apis['character'];
    }

    /**
     * Returns the classes API
     * @return \WowApi\Api\Classes
     */
    public function getClassesApi()
    {
        if (!isset($this->apis['classes'])) {
            $this->setApi('classes', new Classes($this->getRequest()));
        }

        return $this->apis['classes'];
    }

    /**
     * Returns the guild API
     * @return \WowApi\Api\Guild
     */
    public function getGuildApi()
    {
        if (!isset($this->apis['guild'])) {
            $this->setApi('guild', new Guild($this->getRequest()));
        }

        return $this->apis['guild'];
    }

    /**
     * Returns the guildPerks API
     * @return \WowApi\Api\GuildPerks
     */
    public function getGuildPerksApi()
    {
        if (!isset($this->apis['guildPerks'])) {
            $this->setApi('guildPerks', new GuildPerks($this->getRequest()));
        }

        return $this->apis['guildPerks'];
    }

    /**
     * Returns the guildRewards API
     * @return \WowApi\Api\GuildRewards
     */
    public function getGuildRewardsApi()
    {
        if (!isset($this->apis['guildRewards'])) {
            $this->setApi('guildRewards', new GuildRewards($this->getRequest()));
        }

        return $this->apis['guildRewards'];
    }

    /**
     * Returns the races API
     * @return \WowApi\Api\Races
     */
    public function getRacesApi()
    {
        if (!isset($this->apis['races'])) {
            $this->setApi('races', new Races($this->getRequest()));
        }

        return $this->apis['races'];
    }

    /**
     * Returns the realm API
     * @return \WowApi\Api\Realm
     */
    public function getRealmApi()
    {
        if (!isset($this->apis['realm'])) {
            $this->setApi('realm', new Realm($this->getRequest()));;
        }

        return $this->apis['realm'];
    }

    /**
     * Returns the item API
     * @return \WowApi\Api\Items
     */
    public function getItemsApi()
    {
        if (!isset($this->apis['items'])) {
            $this->setApi('items', new Items($this->getRequest()));;
        }

        return $this->apis['items'];
    }

}
