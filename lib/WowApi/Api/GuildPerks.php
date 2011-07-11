<?php
namespace WowApi\Api;

class GuildPerks extends Api
{
    public function getPerks()
    {
        return $this->get('data/guild/perks');
    }
}
