<?php
namespace WowApi\Api;

class GuildPerks extends AbstractApi
{
    public function getPerks()
    {
        return $this->get('data/guild/perks');
    }
}
