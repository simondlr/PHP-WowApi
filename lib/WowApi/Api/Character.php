<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Character extends Api
{
    public function getCharacter($server, $character, array $fields = array())
    {
        $server = urlencode($server);
        $character = urlencode($character);
        $this->setQueryParam('fields', implode(',', $fields));
        $character = $this->get("character/$server/$character");
        return $character;
    }


}
