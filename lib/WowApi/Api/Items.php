<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Items extends Api
{
    public function getItem($itemId)
    {
        $itemId = (int)$itemId;
        $item = $this->get("data/item/$itemId");
        $item['icon'] = $this->getIconURL($this->getOption('region'), $item['icon']);
        return $item;
    }

    protected function getIconURL($region, $icon, $size = '18')
    {
        return sprintf('http://%s.media.blizzard.com/wow/icons/%d/%s.jpg', $region, $size, $icon);
    }
}
