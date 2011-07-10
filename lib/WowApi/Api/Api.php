<?php
namespace WowApi\Api;

use WowApi\Request\RequestInterface;
use WowApi\Exception\ApiException;

abstract class Api implements ApiInterface {

    protected $whitelist = array();

    protected $parameters = array();

    protected $request = null;

    protected $schema = array();

    public function __construct(RequestInterface $request) {
        $this->request = $request;
    }

    public function get($path, array $options = array()) {
        $return = $this->request->get($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    public function post($path, array $options = array()) {
        $return = $this->request->post($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    public function put($path, array $options = array()) {
        $return = $this->request->put($path, $this->parameters, $options);
        $this->parameters = array();
        return $return;
    }

    public function delete($path, array $options = array()) {
        $return = $this->request->delete($path, $this->parameters, $options);
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
    public function filter($results, $key, $filter) {
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
    protected function setQuery(array $params) {
        $whitelist = $this->getQueryWhitelist();

        if (!empty($whitelist) && !empty($params)) {
            $params = array_filter(array_intersect_key($params, array_flip($whitelist)));
        }

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
    protected function setQueryParam($param, $value) {
        $whitelist = $this->getQueryWhitelist();

        if (!empty($whitelist) && !in_array($param, $whitelist)) {
            throw new ApiException(sprintf('Query param %s is not supported.', $param));
        }

        if (!empty($value)) {
            $this->parameters[$param] = $value;
        }
    }

    /**
     * Return an individual value from the query string.
     *
     * @param string $param
     * @return mixed
     */
    protected function getQueryParam($param) {
        return isset($this->parameters[$param]) ? $this->parameters[$param] : null;
    }
}
