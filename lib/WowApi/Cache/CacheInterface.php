<?php
namespace WowApi\Cache;

interface CacheInterface
{
    function write($key, $data);
    function read($key);
    function getCachedResponse($path, $parameters);
    function setCachedResponse($path, $parameters, $response, $date);
}
