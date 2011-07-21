<?php
namespace WowApi\Request;

use WowApi\Client;
use WowApi\Exception\ApiException;
use WowApi\Exception\RequestException;
use WowApi\Exception\NotFoundException;
use WowApi\Cache\CacheInterface;
use WowApi\Utilities;

abstract class Request implements RequestInterface {
    protected $headers = array(
        'Expect' => '',
        'Accept' => 'application/json',
        'Accept-Encoding' => 'gzip',
        'Content-Type' => 'application/json',
        'User-Agent' => 'PHP WowApi (http://github.com/dancannon/PHP-WowApi)',
    );

    /**
     * @var null|\WowApi\Client
     */
    protected $client = null;

    public function __construct() {
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function get($path, array $parameters = array(), array $options = array()) {
        return $this->send($path, $parameters, 'GET', $options);
    }

    public function post($path, array $parameters = array(), array $options = array()) {
        return $this->send($path, $parameters, 'POST', $options);
    }

    public function put($path, array $parameters = array(), array $options = array()) {
        return $this->send($path, $parameters, 'PUT', $options);
    }

    public function delete($path, array $parameters = array(), array $options = array()) {
        return $this->send($path, $parameters, 'DELETE', $options);
    }

    public function send($path, array $parameters = array(), $httpMethod = 'GET', array $options = array()) {
        $options = array_merge($this->getOptions(), $options);

        // Check the cache
        if ($this->client->getCache() !== null) {
            $cache = $this->client->getCache()->getCachedResponse($path, $parameters);
            $cache = json_decode($cache, true);
            if (isset($cache) && isset($cache['cachedAt']) && (time() - $cache['cachedAt']) < $options['ttl']) {
                return $cache;
            }
            if (isset($cache) && isset($cache['lastModified'])) {
                $this->setHeader('If-Modified-Since', gmdate("D, d M Y H:i:s", $cache['lastModified']) . " GMT");
            }
        }

        // Attempt to authenticate application
        if ($this->getOption('publicKey') !== null && $this->getOption('privateKey') !== null) {
            $stringToSign = "$httpMethod\n" . $this->getHttpDate(time()) . "\n$path\n";
            $signature = base64_encode(hash_hmac('sha1', $stringToSign, utf8_encode($this->getOption('privateKey'))));

            $this->setHeader("Authorization", "BNET " . $this->getOption('publicKey') . "+$signature");
        }

        // Create the full url
        $url = strtr($options['url'], array(
                ':protocol' => $options['protocol'],
                ':region' => $options['region'],
                ':path' => trim($path, '/'),
            ));
        if($httpMethod === 'GET') { $url .= "?" . $this->getQueryString($parameters); }

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
        if ($this->client->getCache() !== null) {
            if(isset($response['lastModified'])) {
                $response['lastModified'] = round($response['lastModified']/1000);
            }

            $response['cachedAt'] = time();
            $response = json_encode($response);

            $this->client->getCache()->setCachedResponse($path, $parameters, $response);
        }

        return $response;
    }

    /**
     * Create an RFC 2822 HTTP-Date from various date values
     *
     * @param string|int $date Date to convert
     *
     * @return string
     */
    public function getHttpDate($date = null) {

        if (!is_numeric($date) && $date !== null) {
            $date = strtotime($date);
        }

        return date(DATE_RFC2822, $date);
    }

    public function getRawHeaders() {
        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $headers;
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
                $queryString[] = $key . '=' . urlencode($value);
            }
        }

        return implode('&', $queryString);
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getHeader($name) {
        return $this->headers[$name];
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
    }

    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
    }

    public function getOption($name) {
        return $this->client->getOption($name);
    }

    public function setOption($name, $value) {
        $this->client->setOption($name, $value);
    }

    public function getOptions() {
        return $this->client->getOptions();
    }

    public function setOptions($options) {
        return $this->client->setOptions($options);
    }
}
