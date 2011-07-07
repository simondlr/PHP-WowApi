<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Guild extends Api
{
    public function getGuild($server, $guild, array $fields=array())
    {
        $server = Utilities::urlencode($server);
        $guild = Utilities::urlencode($guild);
        return $this->request->get("/guild/$server/$guild", array('fields' => implode(',', $fields)));
    }
}
