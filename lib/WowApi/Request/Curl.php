<?php
namespace WowApi\Request;

use WowApi\Exception\Exception;
use WowApi\Exception\RequestException;
use WowApi\Utilities;

if (!function_exists('curl_init')) {
    throw new Exception('This API client needs the cURL PHP extension.');
}

class Curl extends Request
{
    /**
     * Send a request to the server, receive a response
     *
     * @param  string $url Request url
     * @param array $parameters Parameters
     * @param string $httpMethod HTTP method to use
     * @param array $options Request options
     *
     * @return string HTTP response
     */
    public function makeRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        //Set cURL options
        $curlOptions = array(
            CURLOPT_URL            => $url,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_ENCODING       => "gzip",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_VERBOSE        => false,
        );
        if(isset($options['curlOptions'])) {
            $curlOptions = array_merge($options['curlOptions'], $curlOptions);
        }
        $curlOptions[CURLOPT_HTTPHEADER] = $this->getRawHeaders();

		// Prepare Data
        if (!empty($parameters)) {
            $queryString = $this->getQueryString($parameters);

            switch($httpMethod) {
                case 'GET':
                    $curlOptions[CURLOPT_URL] .= "?$queryString";
                    break;
                case 'POST':
                    $curlOptions[CURLOPT_POST] = true;
                    $curlOptions[CURLOPT_POSTFIELDS] = Utilities::encode($parameters);
                    break;
                case 'PUT':
                    $file_handle = fopen($parameters, 'r');
                    $curlOptions[CURLOPT_PUT] = true;
                    $curlOptions[CURLOPT_INFILE] = $file_handle;
                    break;
                case 'DELETE':
                    $curlOptions[CURLOPT_CUSTOMREQUEST] = 'delete';
                    break;
            }
        }

        $response = $this->doCurlCall($curlOptions);
		if ($response['response'] === false) {
			$e = new RequestException($response['errorMessage'], $response['errorNumber']);
            throw $e;
		}else{
			return $response;
		}
    }

    /**
     * Execute the query
     * @param array $curlOptions
     * @return array
     */
    protected function doCurlCall(array $curlOptions)
    {
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        $headers = curl_getinfo($curl);
        $errorNumber = curl_errno($curl);
        $errorMessage = curl_error($curl);

        curl_close($curl);

        return compact('response', 'headers', 'errorNumber', 'errorMessage');
    }
}
