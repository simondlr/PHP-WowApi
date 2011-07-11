<?php
namespace WowApi\Api;

use WowApi\Request\RequestInterface;
use WowApi\Exception\ApiException;

abstract class Api implements ApiInterface
{
    /**
     * @var array Data to be sent
     */
    protected $parameters = array();
    /**
     * @var array The schema data structure for the response
     */
    protected $schema = array();
    /**
     * @var \WowApi\Client
     */
    protected $client = null;

    public function __construct(\WowApi\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Make a GET request
     * @param $path
     * @param array $options
     * @return array
     */
    public function get($path, array $options = array())
    {
        $return = $this->getRequest()->get($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    /**
     * Make a POST request
     * @param $path
     * @param array $options
     * @return array
     */
    public function post($path, array $options = array())
    {
        $return = $this->getRequest()->post($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    /**
     * Make a PUT request
     * @param $path
     * @param array $options
     * @return array
     */
    public function put($path, array $options = array())
    {
        $return = $this->getRequest()->put($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    /**
     * Make a DELETE request
     * @param $path
     * @param array $options
     * @return array
     */
    public function delete($path, array $options = array())
    {
        $return = $this->getRequest()->delete($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    /**
     * Filter down the result set on a key basis.
     *
     * @param array $results
     * @param string $key
     * @param mixed $filter
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
     * @param array $params
     * @return void
     */
    protected function setQuery(array $params)
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $this->setQueryParam($key, $value);
            }
        }
    }

    /**
     * Set a single value into the query string.
     * A whitelist can be provided to only accept specific keys.
     *
     * @param string $param
     * @param mixed $value
     * @return void
     */
    protected function setQueryParam($param, $value)
    {
        $this->parameters[$param] = $value;
    }

    /**
     * Return an individual value from the query string.
     *
     * @param string $param
     * @return mixed
     */
    protected function getQueryParam($param)
    {
        return isset($this->parameters[$param]) ? $this->parameters[$param] : null;
    }

    /**
     * Return the schema structure.
     *
     * @access public
     * @param string $field
     * @return array
     */
    protected function schema($field = null)
    {
        return isset($this->schema[$field]) ? $this->schema[$field] : $this->schema;
    }

    /**
     * @return null|\WowApi\Request\RequestInterface
     */
    public function getRequest()
    {
        return $this->client->getRequest();
    }

    /**
     * Get a single option
     * @param $name
     * @return mixed
     */
    public function getOption($name)
    {
        return $this->client->getOption($name);
    }

    /**
     * Set a single option
     * @param $name
     * @param $value
     * @return void
     */
    public function setOption($name, $value)
    {
        $this->client->setOption($name, $value);
    }

    /**
     * Get an array containing all the options
     * @return array
     */
    public function getOptions()
    {
        return $this->client->getOptions();
    }

    /**
     * Stores an array of options
     * @param $options
     * @return void
     */
    public function setOptions($options)
    {
        $this->client->setOptions($options);
    }
}
