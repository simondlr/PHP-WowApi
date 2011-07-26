<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Character extends Api
{
    public function getCharacter($server, $character, array $fields = array())
    {
        $server = Utilities::encodeUrlParam($server);
        $character = Utilities::encodeUrlParam($character);

        $this->setQueryParam('fields', implode(',', $fields));
        $character = $this->get("character/$server/$character");

        return $character;
    }


}
