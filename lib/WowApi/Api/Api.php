<?php
namespace WowApi\Api;

use WowApi\Request\RequestInterface;
use WowApi\Exception\ApiException;
use WowApi\ParameterBag;

abstract class Api implements ApiInterface
{
    /**
     * @var array Data to be sent
     */
    protected $parameters = null;
    /**
     * @var array The schema data structure for the response
     */
    protected $schema = array();
    /**
     * @var array Array containing allowed query parameters
     */
    protected $queryWhitelist = array();
    /**
     * @var \WowApi\Client
     */
    protected $client = null;

    public function __construct(\WowApi\Client $client)
    {
        $this->client = $client;
        $this->parameters = new ParameterBag();
    }

    /**
     * Make a GET request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function get($path)
    {
        $parameters = $this->parameters->all(true);

        return $this->getRequest()->get($path, $parameters);
    }

    /**
     * Make a POST request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function post($path)
    {
        $parameters = $this->parameters->all(true);

        return $this->getRequest()->post($path, $parameters);
    }

    /**
     * Make a PUT request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function put($path)
    {
        $parameters = $this->parameters->all(true);

        return $this->getRequest()->put($path, $parameters);
    }

    /**
     * Make a DELETE request
     *
     * @param string $path API Path
     *
     * @return array
     */
    public function delete($path)
    {
        $parameters = $this->parameters->all(true);

        return $this->getRequest()->delete($path, $parameters);
    }

    /**
     * Filter down the result set on a key basis.
     *
     * @param array  $results Results to be filtered
     * @param string $key     Key to be filtered by
     * @param mixed  $filter  Filter function
     *
     * @return array
     */
    public function filter($results, $key, $filter)
    {
        $clean = array();

        if (!empty($results)) {
            foreach ($results as $result) {
                if (!isset($result[$key])) {
                    continue;
                }

                if (is_array($filter) && in_array($result[$key], $filter)) {
                    $clean[] = $result;

                } else {
                    if ($filter instanceof \Closure && $filter($result[$key])) {
                        $clean[] = $result;

                    } else {
                        if ($result[$key] == $filter) {
                            $clean[] = $result;
                        }
                    }
                }
            }
        }

        return $clean;
    }

    /**
     * Set multiple values of the query string using an array.
     * A whitelist can be provided to only accept specific keys.
     *
     * @param array $params Query parameters
     *
     * @return void
     */
    protected function setQueryParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->setQueryParam($key, $value);
        }
    }

    /**
     * Set a single value into the query string.
     * A whitelist can be provided to only accept specific keys.
     *
     * @param string $param Parameter name
     * @param mixed  $value Parameter Value
     *
     * @return void
     */
    protected function setQueryParam($param, $value)
    {
        if (!in_array($param, $this->queryWhitelist)) {
            $this->parameters[$param] = $value;
        }
    }

    /**
     * Return an individual value from the query string.
     *
     * @param string $param   Parameter key
     * @param null   $default The default value to be returned
     *
     * @return mixed
     */
    protected function getQueryParam($param, $default = null)
    {
        return $this->parameters->get($param, $default);
    }

    /**
     * Return the schema structure.
     *
     * @param null|string $field Schema name
     *
     * @return array
     */
    protected function schema($field = null)
    {
        if ($field === null) {
            return $this->schema;
        } else {
            if (isset($this->schema[$field])) {
                return $this->schema[$field];
            } else {
                return false;
            }
        }
    }

    /**
     * Return the request
     *
     * @return null|\WowApi\Request\RequestInterface
     */
    public function getRequest()
    {
        return $this->client->getRequest();
    }
}
