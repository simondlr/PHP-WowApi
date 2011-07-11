<?php
namespace WowApi\Api;

class Classes extends Api
{
    public function getClasses()
    {
        return $this->get('data/character/classes');
    }
}
