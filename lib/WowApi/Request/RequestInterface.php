<?php
namespace WowApi\Request;

use WowApi\Cache\CacheInterface;

interface RequestInterface
{
    function get($path, array $parameters = array(), array $options = array());
    function post($path, array $parameters = array(), array $options = array());
    function put($path, array $parameters = array(), array $options = array());
    function delete($path, array $parameters = array(), array $options = array());
    function send($path, array $parameters = array(), $httpMethod = 'GET', array $options = array());
    function makeRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array());
    function setCache(CacheInterface $cache);       
    function getRawHeaders();
    function getHeaders();
    function getHeader($name);
    function setHeaders($headers);
    function setHeader($name, $value);
    function getOption();
    function setOption($name, $value);
    function getOptions();
    function setOptions($options);
}
