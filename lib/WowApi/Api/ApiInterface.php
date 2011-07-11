<?php
namespace WowApi\Api;

use \WowApi\Request\RequestInterface;

interface ApiInterface
{
    /**
     * Make a GET request
     * @param $path
     * @param array $options
     */
    public function get($path, array $options = array());

    /**
     * Make a POST request
     * @param $path
     * @param array $options
     */
    public function post($path, array $options = array());

    /**
     * Make a PUT request
     * @param $path
     * @param array $options
     * @return void
     */
    public function put($path, array $options = array());

    /**
     * Make a DELETE request
     * @param $path
     * @param array $options
     * @return void
     */
    public function delete($path, array $options = array());

    /**
     * Filter down the result set on a key basis.
     *
     * @param array $results
     * @param string $key
     * @param mixed $filter
     * @return array
     */
    public function filter($results, $key, $filter);
}
