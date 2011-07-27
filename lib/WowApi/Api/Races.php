<?php
namespace WowApi\Api;

class Races extends AbstractApi
{
    public function getRaces()
    {
        return $this->get('data/character/races');
    }
}
