<?php

namespace Validation\Rules;

class BetweenRule extends Rule
{
    protected $lower;
    protected $upper;

    public function __construct($lower, $upper)
    {
        $this->lower = $lower;
        $this->upper = $upper;
    }

    public function passes($field, $value)
    {
        return strlen($value) >= $this->lower && strlen($value) <= $this->upper;
    }

    public function message($field)
    {
        return $field . ' must be between '. $this->lower .' and '. $this->upper .' characters!';
    }
}