<?php
namespace WowApi\Cache;

interface CacheInterface
{
    /**
     * @abstract
     * @param $key
     * @param $data
     * @return void
     */
    function write($key, $data);
    /**
     * @abstract
     * @param $key
     * @return void
     */
    function read($key);
    /**
     * @abstract
     * @param $url
     * @param $parameters
     * @return void
     */
    function getCachedResponse($url, $parameters);
    /**
     * @abstract
     * @param $url
     * @param $parameters
     * @param $response
     * @return void
     */
    function setCachedResponse($url, $parameters, $response);
}
