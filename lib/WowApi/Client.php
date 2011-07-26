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
     * @var null|\WowApi\ParameterBag API Options
     */
    public $options = null;

    /**
     * @var array Array containing the instances of the API classes
     */
    public $apis = null;

    public function __construct($options = array())
    {
        $this->apis = new ApiBag();
        $this->setCache(new Cache\Null());
        $this->options = new ParameterBag(array(
            'protocol' => 'http',
            'region' => 'us',
            'url' => ':protocol://:region.battle.net/api/wow/:path',
            'publicKey' => null,
            'privateKey' => null,
            'ttl' => 3600,
        ));
    }

    /**
     * Return supported regions
     * @return array
     */
    protected function getSupportedRegions() {
        return array('us', 'eu', 'kr', 'tw', 'cn');
    }

    /**
     * Make an API call
     * @param $path
     * @param array $parameters
     * @param string $httpMethod
     * @param array $options
     * @return array
     */
    public function api($path, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        return $this->getRequest()->send($path, $parameters, $httpMethod, $options);
    }

    /**
     * Authenticate the application
     * @param $publicKey
     * @param $privateKey
     * @return void
     */
    public function authenticate($publicKey, $privateKey)
    {
        $this->options->set('publicKey', $publicKey);
        $this->options->set('privateKey', $privateKey);
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
            $this->options->set('region', $region);
        } else {
            throw new \InvalidArgumentException(sprintf('The region %s is not supported.', $region));
        }
    }

    /**
     * Get the request object

     *
     * @internal param $ Exception\Exception
     * @return \WowApi\Request\RequestInterface
     */
    public function getRequest() {
        if($this->request === null) {
            throw new Exception("A request class must be specified.");
        }

        return $this->request;
    }

    /**
     * Set the request object
     * @param \WowApi\Request\RequestInterface $request
     * @return void
     */
    public function setRequest(\WowApi\Request\RequestInterface $request) {
        $request->setClient($this);
        $this->request = $request;
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
     * @return Cache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /** API's **/

    /**
     * Returns the character API
     * @return \WowApi\Api\Character
     */
    public function getCharacterApi()
    {
        if (!$this->apis->get('character')) {
            $this->apis->set('character', new Character($this));
        }

        return $this->apis->get('character');
    }

    /**
     * Returns the classes API
     * @return \WowApi\Api\Classes
     */
    public function getClassesApi()
    {
        if (!$this->apis->has('classes')) {
            $this->apis->set('classes', new Classes($this));
        }

        return $this->apis->get('classes');
    }

    /**
     * Returns the guild API
     * @return \WowApi\Api\Guild
     */
    public function getGuildApi()
    {
        if (!$this->apis->has('guild')) {
            $this->apis->set('guild', new Guild($this));
        }

        return $this->apis->get('guild');
    }

    /**
     * Returns the guildPerks API
     * @return \WowApi\Api\GuildPerks
     */
    public function getGuildPerksApi()
    {
        if (!$this->apis->get('guildPerks')) {
            $this->apis->set('guildPerks', new GuildPerks($this));
        }

        return $this->apis->get('guildPerks');
    }

    /**
     * Returns the guildRewards API
     * @return \WowApi\Api\GuildRewards
     */
    public function getGuildRewardsApi()
    {
        if (!$this->apis->has('guildRewards')) {
            $this->apis->set('guildRewards', new GuildRewards($this));
        }

        return $this->apis->get('guildRewards');
    }

    /**
     * Returns the races API
     * @return \WowApi\Api\Races
     */
    public function getRacesApi()
    {
        if (!$this->apis->has('races')) {
            $this->apis->set('races', new Races($this));
        }

        return $this->apis->get('races');
    }

    /**
     * Returns the realm API
     * @return \WowApi\Api\Realm
     */
    public function getRealmApi()
    {
        if (!$this->apis->get('realm')) {
            $this->apis->set('realm', new Realm($this));;
        }

        return $this->apis->get('realm');
    }

    /**
     * Returns the item API
     * @return \WowApi\Api\Items
     */
    public function getItemsApi()
    {
        if (!$this->apis->has('items')) {
            $this->apis->set('items', new Items($this));;
        }

        return $this->apis->get('items');
    }

}
