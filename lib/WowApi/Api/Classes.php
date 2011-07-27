<?php
namespace WowApi\Api;

class Classes extends AbstractApi
{
    public function getClasses()
    {
        return $this->get('data/character/classes');
    }
}
