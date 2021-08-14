<?php

namespace Cookies;

abstract class GetParams
{
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    abstract public function setParams();

    abstract public function getParams();

}