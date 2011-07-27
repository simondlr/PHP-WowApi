<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Items extends AbstractApi
{
    public function getItem($itemId)
    {
        $itemId = (int)$itemId;
        $item = $this->get("data/item/$itemId");

        return $item;
    }
}
