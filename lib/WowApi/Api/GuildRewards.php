<?php
namespace WowApi\Api;

class GuildRewards extends Api
{
    public function getRewards()
    {
        return $this->request->get('data/guild/rewards');
    }
}
