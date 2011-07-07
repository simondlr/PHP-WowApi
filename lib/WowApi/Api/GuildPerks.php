<?php
namespace WowApi\Api;

class GuildPerks extends Api
{
    public function getPerks()
    {
        return $this->request->get('data/guild/perks');
    }
}
