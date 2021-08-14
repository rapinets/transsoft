<?php

namespace Validation\Rules;

class MinRule extends Rule
{
    protected $max;

    public function __construct($min)
    {
        $this->max = $min;
    }


    public function passes($field, $value)
    {
        return strlen($value) >= $this->min;
    }

    public function message($field)
    {
        return $field . ' should be more than ' . $this->min . ' characters!';
    }
}