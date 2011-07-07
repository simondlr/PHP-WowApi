<?php
namespace WowApi\Api;

use WowApi\Request\RequestInterface;

abstract class Api implements ApiInterface
{
    protected $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
}
