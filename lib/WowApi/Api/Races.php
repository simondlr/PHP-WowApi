<?php
namespace WowApi\Api;

class Races extends Api
{
    public function getRaces()
    {
        return $this->get('data/character/races');
    }
}
