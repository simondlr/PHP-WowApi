<?php
namespace WowApi\Api;

class Classes extends Api
{
    public function getClasses()
    {
        return $this->request->get('data/character/classes');
    }
}
