<?php

namespace Validation\Errors;

class ErrorBag
{
    protected $errors = [];

    public function add($key, $value) 
    {
        $this->errors[$key][] = $value;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return empty($this->errors);
    }
}
