<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Items extends Api
{
    public function getItem($itemId)
    {
        $itemId = Utilities::urlencode($itemId);
        return $this->request->get("data/item/$itemId");
    }
}
