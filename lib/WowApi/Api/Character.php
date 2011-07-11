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
        $character['thumbnail'] = $this->getThumbnailUrl($this->getOption('region'), $character['thumbnail']);
        return $character;
    }

    protected function getThumbnailUrl($region, $thumbnail)
    {
        return sprintf('http://%1$s.battle.net/static-render/%1$s/%2$s', $region, $thumbnail);
    }
}
