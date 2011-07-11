<?php

use WowApi\Request\Curl;

class Shared
{
    public static $keys = array(
        'public'  => null,
        'private' => null,
    );

    /**
     * @static
     * @return WowApi\Client
     */
    public static function Client() {
        $client = new \WowApi\Client();
        $client->setRegion('us');
        $client->setRequest(new Curl($client));
        return $client;
    }

    public static function getKeys() {
    }
}
