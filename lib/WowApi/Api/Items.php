<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Items extends AbstractApi
{
    public function getItem($itemId)
    {
        $item = $this->get($this->generatePath('data/item/:itemId', array(
            'itemid' => (int)$itemId)
        ));

        return $item;
    }
}
