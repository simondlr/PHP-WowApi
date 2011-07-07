<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Character extends Api
{
    public function getCharacter($server, $character, array $fields=array())
    {
        $server = Utilities::urlencode($server);
        $character = Utilities::urlencode($character);
        return $this->request->get("character/$server/$character", array('fields' => implode(',', $fields)));
    }
}
