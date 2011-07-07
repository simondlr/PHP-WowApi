<?php
namespace WowApi;

use WowApi\Request\Curl;
use WowApi\Cache\CacheInterface;
use WowApi\Request\Request;
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


if (!function_exists('curl_init')) {
    throw new \Exception('This API client needs the cURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new \Exception('This API client needs the JSON PHP extension.');
}

class Client
{
    protected $request = null;

    protected $apis;

    protected $region;

    protected $regions = array(
        'us' => 'us.battle.net',
        'eu' => 'eu.battle.net',
        'kr' => 'kr.battle.net',
        'tw' => 'tw.battle.net',
        'cn' => 'battlenet.com.cn',
    );

    public function __construct($options = array())
    {
        $this->request = new Curl($options);
    }

    public function authenticate($publicKey, $privateKey)
    {
        $this->getRequest()->setOption('publicKey', $publicKey);
        $this->getRequest()->setOption('privateKey', $privateKey);
    }

    public function setRegion($region)
    {
        if(array_key_exists($region, $this->regions)) {
            $this->region = $region;
            $this->getRequest()->setOption('region', $region);
            $this->getRequest()->setOption('baseUrl', $this->regions[$region]);
        } else {
            throw new \InvalidArgumentException("That region is not valid");
        }
    }

    public function setCache(CacheInterface $cache)
    {
        $this->getRequest()->setCache($cache);
    }

    public function setOption($name, $value)
    {
        $this->getRequest()->setOption($name, $value);
    }

    public function api($path, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        $this->getRequest()->send($path, $parameters, $httpMethod, $options);
    }

    public function getRequest() {
        return $this->request;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function getApi($name)
    {
        return $this->apis[$name];
    }

    public function setApi($name, ApiInterface $instance)
    {
        $this->apis[$name] = $instance;
    }

    /** API's **/

    /**
     * Return the character API
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
     * Return the classes API
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
     * Return the guild API
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
     * Return the guildPerks API
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
     * Return the guildRewards API
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
     * Return the races API
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
     * Return the realm API
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
     * Return the item API
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
