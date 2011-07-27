<?php
namespace WowApi\Api;

use WowApi\Request\RequestInterface;
use WowApi\Exception\ApiException;
use WowApi\ParameterBag;
use WowApi\Utilities;

abstract class AbstractProfileApi extends AbstractApi
{
    /**
     * @var array Array containing allowed fields
     */
    protected $fieldsWhitelist = array();

    protected $queryWhitelist = array('fields');

    /**
     * Set profile fields to be fetched
     *
     * @param array $fields Fields
     *
     * @return void
     */
    protected function setFields($fields)
    {
        if(is_array($fields)) {
            foreach ( $fields as $field ) {
                if ( !in_array($field, $this->fieldsWhitelist) ) {
                    throw new \InvalidArgumentException(sprintf('The field `%s` was not recognized.', $field));
                }
            }
        } elseif($fields === true) {
            $fields = $this->fieldsWhitelist;
        } else {
            throw new \InvalidArgumentException("The argument passed to setFields was invalid");
        }

        $this->setQueryParam('fields', $fields);
    }
}
