<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Guild extends Api
{
    public function getGuild($server, $guild, array $fields = array())
    {
        $server = Utilities::encodeUrlParam($server);
        $guild = Utilities::encodeUrlParam($guild);

        $this->setQueryParam('fields', implode(',', $fields));
        $guild = $this->get("/guild/$server/$guild");

        return $guild;
    }
}
