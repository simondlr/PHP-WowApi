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
     * @param $path
     * @param $parameters
     * @return void
     */
    function getCachedResponse($path, $parameters);
    /**
     * @abstract
     * @param $path
     * @param $parameters
     * @param $response
     * @return void
     */
    function setCachedResponse($path, $parameters, $response);
}
