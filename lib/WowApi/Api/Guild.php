<?php
namespace WowApi\Api;

use WowApi\Utilities;

class Guild extends AbstractProfileApi
{
    protected $fieldsWhitelist = array('members', 'achievements');

    public function getGuild($realm, $guild, $fields = array())
    {
        $this->setFields($fields);

        $guild = $this->get($this->generatePath('guild/:realm/:guild', array(
            'realm' => $realm,
            'guild' => $guild,
        )));

        return $guild;
    }
}
