<?php
namespace WowApi\Api;

use \WowApi\Request\RequestInterface;

interface ApiInterface
{
    function __construct(RequestInterface $request);
}
