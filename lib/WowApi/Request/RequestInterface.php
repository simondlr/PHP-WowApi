<?php
namespace WowApi\Request;

interface RequestInterface
{
    function get($path, array $parameters = array(), array $options = array());
    function post($path, array $parameters = array(), array $options = array());
    function put($path, array $parameters = array(), array $options = array());
    function delete($path, array $parameters = array(), array $options = array());
    function send($path, array $parameters = array(), $httpMethod = 'GET', array $options = array());
    function makeRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array());
}
