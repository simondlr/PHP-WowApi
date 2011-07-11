<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Guild extends Api
{
    public function getGuild($server, $guild, array $fields = array())
    {
        $server = urlencode($server);
        $guild = urlencode($guild);
        $this->setQueryParam('fields', implode(',', $fields));
        return $this->get("/guild/$server/$guild");
    }
}
