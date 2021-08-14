<?php

namespace Validation\Rules;

class MaxRule extends Rule
{
    protected $max;

    public function __construct($max)
    {
        $this->max = $max;
    }


    public function passes($field, $value)
    {
        return strlen($value) <= $this->max;
    }

    public function message($field)
    {
        return $field . ' must be a max of ' . $this->max . ' characters!';
    }
}