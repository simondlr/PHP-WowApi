<?php
namespace WowApi\Api;

class GuildRewards extends AbstractApi
{
    public function getRewards()
    {
        return $this->get('data/guild/rewards');
    }
}
