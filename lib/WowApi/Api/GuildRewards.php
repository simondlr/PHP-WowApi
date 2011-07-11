<?php
namespace WowApi\Api;

class GuildRewards extends Api
{
    public function getRewards()
    {
        return $this->get('data/guild/rewards');
    }
}
