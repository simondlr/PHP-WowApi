<?php
namespace WowApi\Api;

use WowApi\Exception\ApiException;

class Realm extends Api
{
    public function getRealm($realm) {
        return $this->getRealms(array($realm));
    }


	/**
	 * Get status results for specified realm(s).
	 *
	 * @param array $realms String or array of realm(s)
	 * @return mixed
	 */
	public function getRealms(array $realms = array()) {
		if (empty($realms)) {
			return $this->request->get('realm/status');
		} else {
            return $this->request->get('realm/status', array('realms' => implode(',', $realms)));
		}
	}
}
