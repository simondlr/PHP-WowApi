<?php
namespace WowApi\Api;

use \WowApi\Request\RequestInterface;

interface ApiInterface
{
    function __construct(RequestInterface $request);

    /**
     * Get an array of allowed query parameters
     * @return array
     */
    function getQueryWhitelist();
}
