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
    function makeRequest($url, $method='GET', array $parameters=array());

    /**
     * Make a GET request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function get($path, array $parameters = array());
    /**
     * Make a POST request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function post($path, array $parameters = array());
    /**
     * Make a PUT request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function put($path, array $parameters = array());
    /**
     * Make a DELETE request
     * @param $path
     * @param array $parameters
     * @param array $options
     * @return array
     */
    function delete($path, array $parameters = array());

    /**
     * Makes a request
     * @param $path
     * @param array $parameters
     * @param string $httpMethod
     * @param array $options
     * @return array
     */
    function send($path, $method='GET', array $parameters=array());
    /**
     * @abstract
     * @param \WowApi\Client $client
     * @return void
     */
    function setClient(Client $client);
}
