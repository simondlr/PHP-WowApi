<?php
namespace WowApi\Request;

use WowApi\Client;
use WowApi\Exception\ApiException;
use WowApi\Exception\RequestException;
use WowApi\Exception\NotFoundException;
use WowApi\Cache\CacheInterface;
use WowApi\ParameterBag;
use WowApi\Utilities;

abstract class Request implements RequestInterface {
    /**
     * @var null|\WowApi\Request\HeaderBag
     */
    public $headers = null;

    /**
     * @var null|\WowApi\Client
     */
    protected $client = null;

    public function __construct() {
        $this->headers = new HeaderBag(array(
            'Expect'            => '',
            'Accept'            => 'application/json',
            'Accept-Encoding'   => 'gzip',
            'Content-Type'      => 'application/json',
            'User-Agent'        => 'PHP WowApi (http://github.com/dancannon/PHP-WowApi)',
        ));
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function get($path, array $parameters = array()) {
        return $this->send($path, $parameters, 'GET');
    }

    public function post($path, array $parameters = array()) {
        return $this->send($path, $parameters, 'POST');
    }

    public function put($path, array $parameters = array()) {
        return $this->send($path, $parameters, 'PUT');
    }

    public function delete($path, array $parameters = array()) {
        return $this->send($path, $parameters, 'DELETE');
    }

    public function send($path, array $parameters = array(), $httpMethod = 'GET') {
        $options = $this->client->options;

        // Check the cache
        if (($cache = $this->client->getCache()->getCachedResponse($path, $parameters) === false)) {
            $cache = json_decode($cache, true);

            if (isset($cache) && isset($cache['cachedAt']) && (time() - $cache['cachedAt']) < $options['ttl']) {
                return $cache;
            }
            if (isset($cache) && isset($cache['lastModified'])) {
                $this->headers->set('If-Modified-Since', gmdate("D, d M Y H:i:s", $cache['lastModified']) . " GMT");
            }
        }

        // Create the full url
        $url = strtr($options->get('url'), array(
                ':protocol' => $options->get('protocol'),
                ':region' => $options->get('region'),
                ':path' => trim($path, '/'),
            ));
        if($httpMethod === 'GET' && $parameters) {
            $url .= "?" . $this->getQueryString($parameters);
        }

        // Get response
        $response = $this->makeRequest($url, $parameters, $httpMethod, $options);
        $httpCode = $response['headers']['http_code'];
        //Check for 304 Not Modified header
        if (isset($cache) && $httpCode === 304) {
            return $cache;
        } else {
            if (strpos($response['headers']['content_type'], 'application/json') !== false) {
                $response = json_decode($response['response'], true);
            } else {
                $response = (array)$response['response'];
            }
            // Check for errors
            if($httpCode === 404) {
                if (isset($response['reason'])) {
                    throw new NotFoundException($response['reason']);
                } else {
                    throw new NotFoundException("Resource not found");
                }
            } elseif ((isset($response['status']) && $response['status'] === 'nok') || ($httpCode !== 200)) {
                if (isset($response['reason'])) {
                    throw new ApiException($response['reason'], $httpCode);
                } else {
                    throw new ApiException("Unknown error", $httpCode);
                }
            }
        }

        //Cache the result
        if(isset($response['lastModified'])) {
            $response['lastModified'] = round($response['lastModified']/1000);
        }

        $response['cachedAt'] = time();
        $cache = json_encode($response);

        $this->client->getCache()->setCachedResponse($path, $parameters, $cache);

        return $response;
    }

    protected function authenticate($httpMethod, $path)
    {
        // Attempt to authenticate application
        $publicKey = $this->client->options->get('publicKey');
        $privateKey = $this->client->options->get('privateKey');
        if ($publicKey !== null && $privateKey !== null) {
            $stringToSign = "$httpMethod\n" . date(DATE_RFC2822) . "\n$path\n";
            $signature = base64_encode(hash_hmac('sha1', $stringToSign, utf8_encode($privateKey)));

            $this->headers->set("Authorization", "BNET $publicKey+$signature");
        }
    }


    /**
     * Return the query string as an array. If $build is true, assemble the query string.
     *
     * @access public
     * @param array $parameters
     * @return string
     */
    public function getQueryString(array $parameters) {
        $queryString = array();

        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                $queryString[] = $key . '=' . $this->getQueryString($value);
            } else {
                $queryString[] = $key . '=' . Utilities::encodeUrlParam($value);
            }
        }

        return implode('&', $queryString);
    }
}
