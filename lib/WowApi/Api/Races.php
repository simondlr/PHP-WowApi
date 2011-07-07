<?php
namespace WowApi\Api;

class Races extends Api
{
    public function getRaces()
    {
        return $this->request->get('data/character/races');
    }
}
