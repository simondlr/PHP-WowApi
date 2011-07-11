<?php
namespace WowApi\Request;

use WowApi\Cache\CacheInterface;
use WowApi\Client;

interface RequestInterface
{
    /**
     * Send a request to the server, receive a response
     *
     * @param  string $url Request url
     * @param array $parameters Parameters
     * @param string $httpMethod HTTP method to use
     * @param array $options Request options
     *
     * @return string HTTP response
     */
    function makeRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array());

    /**
     * Make a GET request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function get($path, array $parameters = array(), array $options = array());
    /**
     * Make a POST request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function post($path, array $parameters = array(), array $options = array());
    /**
     * Make a PUT request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function put($path, array $parameters = array(), array $options = array());
    /**
     * Make a DELETE request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function delete($path, array $parameters = array(), array $options = array());

    /**
     * Makes a request
     * @param $path
     * @param array $parameters
     * @param string $httpMethod
     * @param array $options
     * @return array
     */
    function send($path, array $parameters = array(), $httpMethod = 'GET', array $options = array());
    /**
     * Gets an array containing the headers
     * @abstract
     * @return void
     */
    function getRawHeaders();
    /**
     * @abstract
     * @return void
     */
    function getHeaders();
    /**
     * @abstract
     * @param $name
     * @return void
     */
    function getHeader($name);
    /**
     * @abstract
     * @param $headers
     * @return void
     */
    function setHeaders($headers);
    /**
     * @abstract
     * @param $name
     * @param $value
     * @return void
     */
    function setHeader($name, $value);
    /**
     * @abstract
     * @param $name
     * @return void
     */
    function getOption($name);
    /**
     * @abstract
     * @param $name
     * @param $value
     * @return void
     */
    function setOption($name, $value);
    /**
     * @abstract
     * @return void
     */
    function getOptions();
    /**
     * @abstract
     * @param $options
     * @return void
     */
    function setOptions($options);
    /**
     * @abstract
     * @param \WowApi\Client $client
     * @return void
     */
    function setClient(Client $client);
}
