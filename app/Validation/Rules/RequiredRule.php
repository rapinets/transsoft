<?php

namespace Validation\Rules;

class RequiredRule extends Rule
{
    public function passes($field, $value)
    {
        return !empty($value);
    }

    public function message($field)
    {
        return $field . ' is required!';
    }
}