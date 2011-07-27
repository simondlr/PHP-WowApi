<?php
namespace WowApi\Api;

use WowApi\Request\RequestInterface;

interface ApiInterface
{
    /**
     * Make a GET request
     *
     * @param string $path API Path
     */
    public function get($path);

    /**
     * Make a POST request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function post($path);

    /**
     * Make a PUT request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function put($path);

    /**
     * Make a DELETE request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function delete($path);

    /**
     * Filter down the result set on a key basis.
     *
     * @param array  $results Results to be filtered
     * @param string $key     Key to be filtered by
     * @param mixed  $filter  Filter function
     *
     * @return array
     */
    public function filter($results, $key, $filter);

    /**
     * Generate the API path ensuring that all parameters are encoded correctly
     *
     * @param $path       API Path
     * @param $parameters Parameters
     *
     * @return void
     */
    public function generatePath($path, $parameters);
}
