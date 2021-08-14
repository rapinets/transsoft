<?php

namespace Cookies;



class Cookie extends GetParams
{
    
    public function __construct($params)
    {
        parent::__construct($params);
    }
    
    protected function setCookies()
    {
        foreach($this->params as $key => $value){
            !empty($key) ? setcookie("sortParams[$key]", $value) : null;
        }
    }

    public function setParams()
    {
        return $this->setCookies();
    }

    protected function getCookies()
    {
       return $_COOKIE['sortParams'];
    }

    public function getParams()
    {
        return $this->getCookies();
    }
    
}