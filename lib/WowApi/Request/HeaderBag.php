<?php
namespace WowApi\Request;

use WowApi\ParameterBag;

class HeaderBag extends ParameterBag
{
    /**
     * Returns the parameters.
     *
     * @return array An array of parameters
     *
     * @api
     */
    public function getHeaders($clear=false)
    {
        $parameters = array();
        foreach($this->parameters as $key => $parameter) {
            $parameters[] = "$key: $parameter";
        }

        if($clear === true) {
            $this->parameters = array();
        }

        return $parameters;
    }
}
